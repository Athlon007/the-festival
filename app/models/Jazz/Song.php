<?php

class Song implements JsonSerializable
{
    private $id;
    private string $name;
    private $length;
    private $href;

    public function __construct($id, $name, $length, $href)
    {
        $this->id = $id;
        $this->name = $name;
        $this->length = $length;
        $this->href = $href;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($value)
    {
        $this->name = $value;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength($value)
    {
        $this->length = $value;
    }

    public function getHref()
    {
        return $this->href;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'length' => $this->getLength(),
            'href' => $this->getHref()
        ];
    }
}
