<?php

namespace Btn\TagBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Btn\TagBundle\Model\AbstractTag;

/**
 * @ORM\Table(name="btn_tag", indexes={
 *     @ORM\Index(name="slug_idx", columns={"slug"}),
 * })
 * @ORM\Entity()
 */
class Tag extends AbstractTag
{
}
