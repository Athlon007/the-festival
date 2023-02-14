<?php

require_once("models/Exceptions/PageNotFoundException.php");
require_once("models/Exceptions/FileDoesNotExistException.php");

class Router
{
    const PAGE_NOT_FOUND_PATH = "/views/404.php";

    /**
     * The default entry path from /public/index.php.
     */
    public function route($request): void
    {
        // TODO: Add routing :)
        require_once("services/PageService.php");
        $pageService = new PageService();

        try {
            // First we try to load the page from database.
            $page = $pageService->getPageByHref($request);
            require(__DIR__ . $page->getLocation());
        } catch (PageNotFoundException $ex) {
            // Page was not found?
            // Use static routing instead.
            $this->staticRouting($request);
        } catch (FileDoesNotExistException $ex) {
            // File does not exist?
            // Use static routing instead.
            $this->staticRouting($request);
        } catch (Throwable $ex) {
            $this->route404();

            // DEBUG.
            echo $ex->getMessage() . "<br>" . $ex->getTraceAsString();
        }
    }

    /**
     * Used if no page with no provided Href was found.
     * Contains a list of all dynamically linked pages
     */
    private function staticRouting($request)
    {
        switch ($request) {
            case "":
            case "/home":
            case "/home/":
            case "/home/index":
            case "/home/index/":
                require_once("controllers/HomeController.php");
                $homeController = new HomeController();
                $homeController->index();
                break;
            default:
                $this->route404();
                break;
        }
    }

    /**
     * Loads the 404 page.
     */
    private function route404()
    {
        require(__DIR__ . Router::PAGE_NOT_FOUND_PATH);
    }
}
