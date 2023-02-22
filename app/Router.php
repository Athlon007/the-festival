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
        if (str_starts_with($request, "/api")) {
            require_once("controllers/APIController.php");
            $apiController = new APIController();
            $apiController->handleGetRequest($request);
            $apiController->handlePostRequest($request);
            return;
        }

        require_once("services/PageService.php");
        $pageService = new PageService();

        try {
            // First we try to load the page from database.
            $page = $pageService->getPageByHref($request);
            // If page is type of TextPage
            if ($page instanceof TextPage) {
                // Load the controller for the TextPage
                require_once("controllers/TextPageController.php");
                $textPageController = new TextPageController();
                $textPageController->loadPage($page);
            } else {
                require(__DIR__ . $page->getLocation());
            }
        } catch (PageNotFoundException $ex) {
            // Page was not found?
            // Use static routing instead.
            $this->staticRouting($request, $ex->getMessage());
        } catch (FileDoesNotExistException $ex) {
            // File does not exist?
            // Use static routing instead.
            $this->staticRouting($request, $ex->getMessage());
        } catch (Throwable $ex) {
            $this->route404($ex->getMessage());
        }
    }

    /**
     * Used if no page with no provided Href was found.
     * Contains a list of all dynamically linked pages
     */
    private function staticRouting($request, $message = null)
    {
        // remove last / if it exists
        if (strlen($request) > 0 && substr($request, -1) == '/') {
            $request = rtrim($request, "/");
        }
        switch ($request) {
            case "":
            case "/home":
            case "/home/index":
                require_once("services/PageService.php");
                $pageService = new PageService();
                $page = $pageService->getPageByHref("/");
                require_once("controllers/TextPageController.php");
                $textPageController = new TextPageController();
                $textPageController->loadPage($page);
                break;
            case "/admin/editor":
                require("views/admin/editor.php");
                break;
            case "/home/login":
                require_once("controllers/HomeController.php");
                $homeController = new HomeController();
                $homeController->login();
                break;
            case "/home/register":
                require_once("controllers/HomeController.php");
                $homeController = new HomeController();
                $homeController->register();
                break;
            default:
                $this->route404($message);
                break;
        }
    }

    /**
     * Loads the 404 page.
     */
    private function route404($message)
    {
        require(__DIR__ . Router::PAGE_NOT_FOUND_PATH);
        echo $message;
    }
}
