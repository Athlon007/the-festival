<?php

class Page implements JsonSerializable
{
    private $id;
    private $title;
    private $href;

    public function __construct($id, $title, $href)
    {
        $this->id = $id;
        $this->title = $title;
        $this->href = $href;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($value)
    {
        $this->title = $value;
    }

    public function getHref()
    {
        return $this->href;
    }

    public function setHref($value)
    {
        $this->href = $value;
    }

    public function jsonSerialize(): mixed
    {
        return [
            "id" => $this->getId(),
            "title" => $this->getTitle(),
            "href" => $this->getHref()
        ];
    }
}
