<?php

require_once("Page.php");

class Settings
{
    private Page $indexPage;
    private Page $pageNotFoundPage;

    public function __construct(Page $indexPage, $pageNotFoundPage)
    {
        $this->indexPage = $indexPage;
        $this->pageNotFoundPage = $pageNotFoundPage;
    }

    public function getIndexPage(): Page
    {
        return $this->indexPage;
    }

    public function setIndexPage(Page $value)
    {
        $this->indexPage = $value;
    }

    public function getPageNotFoundPage(): Page
    {
        return $this->pageNotFoundPage;
    }

    public function setPageNotFoundPage(Page $value)
    {
        $this->pageNotFoundPage = $value;
    }
}
