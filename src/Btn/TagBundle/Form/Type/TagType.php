<?php

namespace Btn\TagBundle\Form\Type;

use Btn\AdminBundle\Form\Type\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TagType extends AbstractType
{
    /** @var \Doctrine\Common\Collections\ArrayCollection $tags */
    protected $tags;

    /**
     *
     */
    protected function getTags()
    {
        if (is_null($this->tags)) {
            $this->tags = $this->entityProvider->getRepository()->findAll();
        }

        return $this->tags;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $choices = array();

        foreach ($this->getTags() as $tag) {
            $choices[$tag->getId()] = (string) $tag;
        }

        $resolver->setDefaults(array(
            'choices' => $choices,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_tag';
    }
}
