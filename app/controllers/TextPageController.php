<?php

require_once("../models/TextPage.php");

class TextPageController
{
    const TEXT_PAGE_PATH = "/../views/textpage.php";

    public function loadPage($page)
    {
        $title = $page->getTitle();
        $content = $page->getContent();
        $images = $page->getImages();
        require(__DIR__ . self::TEXT_PAGE_PATH);
    }
}
