<?php
require_once("../repositories/PageRepository.php");
require_once("../models/Exceptions/PageNotFoundException.php");
require_once("../models/Exceptions/FileDoesNotExistException.php");

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
     * @throws FileDoesNotExistException If the file does not exist, throws an exception.
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

        $page = null;
        if ($this->repo->countTextPages($href) > 0) {
            $page = $this->repo->getTextPageByHref($href);
        } else {
            $page = $this->repo->getPageByHref($href);
        }

        if ($page == null) {
            throw new PageNotFoundException("Page with href '$href' was not found.");
        }

        if (!($page instanceof TextPage)) {
            // Check if file exists
            $location = "../" .  $page->getLocation();
            if (!file_exists($location)) {
                throw new FileDoesNotExistException("File at '$location' was not found.");
            }
        }

        return $page;
    }

    /**
     * Returns a page by its ID.
     * @param int $id ID of requested page.
     * @return Page A page with matching ID.
     * @throws PageNotFoundException If matching page was not found, throws the PageNotFoundException.
     * @throws FileDoesNotExistException If the file does not exist, throws an exception.
     */
    public function getPageById(int $id): Page
    {
        $id = htmlspecialchars($id);
        $page = $this->repo->getPageById($id);

        if ($page == null) {
            throw new PageNotFoundException("Page with ID '$id' was not found.");
        }

        // Check if file exists
        $location = $page->getLocation();
        if (!file_exists($page->getLocation())) {
            throw new FileDoesNotExistException("File at '$location' was not found.");
        }

        return $page;
    }

    public function getAllTextPages(): array
    {
        return $this->repo->getAllTextPages();
    }

    public function updateTextPage($id, $title, $content, $images)
    {
        $id = htmlspecialchars($id);
        $content = htmlspecialchars($content);
        $title = htmlspecialchars($title);

        // Check if it even exists in table.
        if ($this->repo->countTextPagesById($id) == 0) {
            throw new PageNotFoundException("Page with ID '$id' was not found.");
        }

        require_once("ImageService.php");
        $imageService = new ImageService();
        $imageService->setImagesForPage($id, $images);

        $this->repo->updateTextPage($id, $title, $content);
    }
}
