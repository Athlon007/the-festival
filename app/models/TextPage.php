<?php
require_once("Page.php");

class TextPage extends Page
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

    public function jsonSerialize(): mixed
    {
        // return base
        return parent::jsonSerialize() + [
            'content' => $this->content
        ];
    }
}
