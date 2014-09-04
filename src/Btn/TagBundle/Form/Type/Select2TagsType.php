<?php

namespace Btn\TagBundle\Form\Type;

use Btn\AdminBundle\Form\Type\Select2Type;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Select2TagsType extends Select2Type
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
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $s2options = array(
            'tokenSeparators' => $options['separators'],
            'tags'            => array(),
        );

        if ($options['tags']) {
            $s2options['tags'] = $options['tags'];
        } else {
            foreach ($this->getTags() as $tag) {
                $s2options['tags'][] = (string) $tag;
            }
        }

        $view->vars['attr']['btn-select2-options'] = json_encode($s2options);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setOptional(array(
            'separators',
            'tags',
        ));

        $resolver->setAllowedTypes(array(
            'separators' => array('array'),
            'tags'       => array('null', 'array'),
        ));

        $resolver->setDefaults(array(
            'separators' => array(' ', ','),
            'tags'       => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'btn_select2_hidden';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'btn_select2_tags';
    }
}
