<?php

class Image implements JsonSerializable
{
    private $id;
    private $src;
    private $alt;

    public function __construct($id, $src, $alt)
    {
        $this->id = $id;
        $this->src = $src;
        $this->alt = $alt;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getSrc()
    {
        return $this->src;
    }

    public function setSrc($value)
    {
        $this->src = $value;
    }

    public function getAlt()
    {
        return $this->alt;
    }

    public function setAlt($value)
    {
        $this->alt = $value;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'src' => $this->src,
            'alt' => $this->alt
        ];
    }
}
