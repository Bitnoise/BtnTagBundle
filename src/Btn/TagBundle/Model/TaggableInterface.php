<?php

namespace Btn\TagBundle\Model;

interface TaggableInterface
{
    public function addTag(TagInterface $tag);
    public function getTagNames();
    public function getTags();
    public function hasTag(TagInterface $tag);
    public function removeTag(TagInterface $tag);
}
