<?php
require_once("Page.php");

class TextPage extends Page implements JsonSerializable
{
    public $content;

    public function __construct($id, $title, $href, $content)
    {
        $this->id = $id;
        $this->title = $title;
        $this->href = $href;
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($value)
    {
        $this->content = $value;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'href' => $this->href,
            'content' => $this->content
        ];
    }
}
