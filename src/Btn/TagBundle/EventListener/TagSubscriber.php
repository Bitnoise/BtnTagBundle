<?php

namespace Btn\TagBundle\EventListener;

use Doctrine\ORM\Events;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Btn\TagBundle\Model\TagInterface;
use Btn\TagBundle\Model\TaggableInterface;

class TagSubscriber implements EventSubscriber
{
    protected $className;
    /** @var \Doctrine\ORM\EntityManager $em */
    protected $em;
    /** @var \Doctrine\ORM\UnitOfWork $uow */
    protected $uow;

    /**
     *
     */
    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * {@inheritdoc}
     */
    final public function getSubscribedEvents()
    {
        return array(
            Events::onFlush,
        );
    }

    /**
     *
     */
    public function onFlush(OnFlushEventArgs $args)
    {
        $this->em  = $args->getEntityManager();
        $this->uow = $this->em->getUnitOfWork();

        foreach ($this->uow->getScheduledEntityInsertions() as $entity) {
            if ($entity instanceof TaggableInterface) {
                $this->setTags($entity);
            }
        }

        foreach ($this->uow->getScheduledEntityUpdates() as $entity) {
            if ($entity instanceof TaggableInterface) {
                $this->setTags($entity);
            }
        }
    }

    /**
     *
     */
    protected function setTags(TaggableInterface $entity)
    {
        $tagNames = $entity->getTagNames();
        if (!$tagNames) {
            return;
        }

        $className         = $this->className;
        $entityTags        = $entity->getTags();
        $currentEntityTags = $entityTags ? clone $entityTags : $entityTags;
        $tagClassMetadata  = $this->em->getClassMetadata($this->className);
        $repository        = $this->em->getRepository($this->className);

        foreach ($tagNames as $tagName) {
            $tag = $repository->findOneBySlug($className::slugify($tagName));
            if (!$tag) {
                $tag = new $className();
                $tag->setNameWithSlug($tagName);
                $this->em->persist($tag);
                $this->computeChangeSets($tag, $tagClassMetadata);
            }
            if (!$entity->hasTag($tag)) {
                $entity->addTag($tag);
            }
        }

        foreach ($currentEntityTags as $currentEntityTag) {
            if (!in_array($currentEntityTag->getName(), $tagNames)) {
                $entity->removeTag($currentEntityTag);
            }
        }

        $this->computeChangeSets($entity);
    }

    /**
     *
     */
    protected function computeChangeSets($entity, $classMetadata = null)
    {
        if (null === $classMetadata) {
            $classMetadata = $this->em->getClassMetadata(get_class($entity));
        }
        $this->uow->computeChangeSets($classMetadata, $entity);
    }
}
