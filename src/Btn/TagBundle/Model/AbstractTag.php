<?php

namespace Btn\TagBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Btn\BaseBundle\Util\Text;

/**
 * @ORM\MappedSuperclass()
 */
abstract class AbstractTag implements TagInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=255)
     * @Assert\Regex(
     *     pattern="/^[_\-a-z0-9]+$/",
     *     message="Slug contains only digits, small letters and chars like '-', '_'"
     * )
     * @Assert\NotBlank()
     */
    protected $slug;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     *
     */
    public function __construct()
    {
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     */
    public function setNameWithSlug($name, $slug = null)
    {
        $this->setName($name);

        if (null === $slug) {
            $slug = self::slugify($name);
        }

        $this->setSlug($slug);
    }

    /**
     *
     */
    public static function slugify($name)
    {
        return Text::slugify($name);
    }

    /**
     *
     */
    public function __toString()
    {
        return $this->getName();
    }

}
