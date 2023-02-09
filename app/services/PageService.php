<?php
require_once("../repositories/PageRepository.php");
require_once("../models/Exceptions/PageNotFoundException.php");

class PageService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new PageRepository();
    }

    /**
     * Returns all available pages.
     * @return array All pages in the database.
     */
    public function getAll(): array
    {
        return $this->repo->getAll();
    }

    /**
     * Returns the page by its href.
     * @param mixed $href Href to the page.
     * @return Page A page with matching href.
     * @throws PageNotFoundException If matching page is not found, throws an exception.
     */
    public function getPageByHref($href): Page
    {
        $href = htmlspecialchars($href);
        // Check if last char is '/'.
        if (strlen($href) > 0 && substr($href, -1) == '/') {
            // If so, remove it from the string.
            // Strings should be saved without the '/' at the end, as it screws with GET requests.
            $href = rtrim($href, "/");
        }

        $page = $this->repo->getPageByHref($href);

        if ($page == null) {
            throw new PageNotFoundException("Page with href '$href' was not found.");
        }

        return $page;
    }

    /**
     * Returns a page by its ID.
     * @param int $id ID of requested page.
     * @return Page A page with matching ID.
     * @throws PageNotFoundException If matching page was not found, throws the PageNotFoundException.
     */
    public function getPageById(int $id): Page
    {
        $id = htmlspecialchars($id);
        $page = $this->repo->getPageById($id);

        if ($page == null) {
            throw new PageNotFoundException("Page with ID '$id' was not found.");
        }

        return $page;
    }
}
