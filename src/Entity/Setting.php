<?php

namespace Svycka\Settings\Entity;

/**
 * @Doctrine\ORM\Mapping\Entity
 * @Doctrine\ORM\Mapping\Table(name="svycka_settings", options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"})
 *
 * @author Vytautas Stankus <svycka@gmail.com>
 * @license MIT
 */
class Setting implements SettingInterface
{
    /**
     * @var int
     * @Doctrine\ORM\Mapping\Id
     * @Doctrine\ORM\Mapping\Column(type="integer", name="id")
     * @Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var int
     * @Doctrine\ORM\Mapping\Column(type="integer", nullable=true)
     */
    protected $identifier;

    /**
     * @var string
     * @Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     */
    protected $collection;

    /**
     * @var string
     * @Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     */
    protected $name;

    /**
     * @var string
     * @Doctrine\ORM\Mapping\Column(type="text", nullable=true)
     */
    protected $value;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setCollection($name)
    {
        $this->collection = $name;
    }

    public function getCollection()
    {
        return $this->collection;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }
}