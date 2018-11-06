<?php

namespace GGGGino\SkuskuCartBundle\EntitySample;

use Doctrine\ORM\Mapping as ORM;
use GGGGino\SkuskuCartBundle\Model\SkuskuLangInterface;

/**
 * SkuskuLanguage
 *
 * @ORM\Table(name="languagee")
 * @ORM\Entity()
 */
class SkuskuLanguage implements SkuskuLangInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="identifier", type="string", length=20, unique=true)
     */
    private $identifier;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     *
     * @return Language
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Language
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * @return bool
     */
    public function getActive()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getIsoCode()
    {
        return $this->getIdentifier();
    }
}

