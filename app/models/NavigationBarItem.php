<?php

require_once("Page.php");

class NavigationBarItem implements JsonSerializable
{
    private $id;
    private Page $page;
    private ?NavigationBarItem $parent;
    private int $order;

    public function __construct($id, Page $page, ?NavigationBarItem $parent, $order)
    {
        $this->id = $id;
        $this->page = $page;
        $this->parent = $parent;
        $this->order = $order;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPage(): Page
    {
        return $this->page;
    }

    public function setPage(Page $value)
    {
        $this->page = $value;
    }

    public function getParent(): ?NavigationBarItem
    {
        return $this->parent;
    }

    public function setParent(NavigationBarItem $value)
    {
        $this->parent = $value;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function setOrder(int $value)
    {
        $this->order = $value;
    }

    public function jsonSerialize(): mixed
    {
        return [
            "id" => $this->getId(),
            "page" => $this->getPage(),
            "parent" => $this->getParent(),
            "order" => $this->getOrder()
        ];
    }
}
