<?php

namespace Btn\TagBundle\Model;

interface TagInterface
{
    public function setSlug($slug);
    public function getSlug();
    public function setName($name);
    public function getName();
    public function setNameWithSlug($name, $slug = null);
    public static function slugify($name);
}
