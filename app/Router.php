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
        // Remove anything after '?'.
        $request = strtok($request, '?');

        if (str_starts_with($request, "/api/")) {
            $this->routeAPI($request);
            return;
        }

        require_once("services/PageService.php");
        $pageService = new PageService();

        try {
            //Start or continue session and create cart if it doesn't exist
            session_start();
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
            }

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

        if (str_starts_with($request, "/updatePassword")) {
            require_once("controllers/AuthController.php");
            $authController = new AuthController();
            $authController->updatePassword();
            return;
        }
        if (str_starts_with($request, "/updateUser")) {
            require_once("controllers/UserController.php");
            $userController = new UserController();
            $userController->updateUser();
            return;
        }

        if (str_starts_with($request, "/ticket")) {
            require_once("controllers/TicketController.php");
            $ticketController = new TicketController();
            $ticketController->markTicketAsScanned();
            return;
        }

        // Uploader redirect.
        if (str_starts_with($request, "/uploader")) {
            require_once("controllers/UploaderController.php");
            $uploaderController = new UploaderController();
            $uploaderController->start($request);
            return;
        }

        if (str_starts_with($request, "/festival/jazz/")) {
            require_once("controllers/FestivalJazzController.php");
            $festivalJazzController = new FestivalJazzController();
            if (str_starts_with($request, "/festival/jazz/artist/")) {
                $festivalJazzController->loadArtistPage($request);
                return;
            } elseif (str_starts_with($request, "/festival/jazz/event/")) {
                $festivalJazzController->loadEventPage($request);
                return;
            }
        }

        if (str_starts_with($request, '/admin/')) {
            $this->routeAdminPanels($request);
            return;
        }

        if (str_starts_with($request, '/manage')) {
            $this->routeAdminManage($request);
            return;
        }

        // split off the ?
        $request = explode("?", $request)[0];

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
            case "/home/login":
            case "/home/account":
                require_once("controllers/HomeController.php");
                $homeController = new HomeController();
                $homeController->account();
                break;
            case "/home/register":
                require_once("controllers/HomeController.php");
                $homeController = new HomeController();
                $homeController->register();
                break;
            case "/provideEmail":
                require_once("controllers/AuthController.php");
                $authController = new AuthController();
                $authController->provideEmail();
                break;
            case "/addUser":
                require_once("controllers/UserController.php");
                $userController = new UserController();
                $userController->addUser();
                break;
            case "/shopping-cart":
                require_once("controllers/OrderController.php");
                $orderController = new OrderController();
                $orderController->showShoppingCart();
                break;
            case "/buyPass":
            case "/buy-pass":
            case "/buypass":
                require_once("views/buy-pass.php");
                break;
            case "/festival/history-stroll":
                require_once("controllers/FestivalHistoryController.php");
                $festivalHistoryController = new FestivalHistoryController();
                $festivalHistoryController->loadHistoryStrollPage();
                break;
            case "/addLocation":
                require_once("controllers/HistoryController.php");
                $historyController = new HistoryController();
                $historyController->addLocation();
                break;
            case "/addTour":
                require_once("controllers/HistoryController.php");
                $historyController = new HistoryController();
                $historyController->addTour();
                break;
            case "/festival/yummy":
            case "/foodfestival":
                require_once("controllers/FestivalFoodController.php");
                $festivalFoodController = new FestivalFoodController();
                $festivalFoodController->loadFoodFestivalPage();
                break;
            case "/buyTicket":
                require_once("controllers/TicketController.php");
                $ticketController = new TicketController();
                $ticketController->getAllJazzTickets();
                break;
            case "/viewOrders":
                require_once("controllers/OrderController.php");
                $ticketController = new OrderController();
                $ticketController->getOrdersToExport();
                break;
            case "/downloadOrders":
                require_once("controllers/OrderController.php");
                $ticketController = new OrderController();
                $ticketController->downloadOrders();
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

    private function routeApi($request)
    {
        $controller = null;

        // Get correct controller
        if (str_starts_with($request, "/api/nav")) {
            require_once("controllers/APIControllers/NavBarAPIController.php");
            $controller = new NavBarAPIController();
        } elseif (str_starts_with($request, "/api/user")) {
            require_once("controllers/APIControllers/UserAPIController.php");
            $controller = new UserAPIController();
        } elseif (str_starts_with($request, "/api/address")) {
            require_once("controllers/APIControllers/AddressAPIController.php");
            $controller = new AddressAPIController();
        } elseif (str_starts_with($request, "/api/textpages")) {
            require_once("controllers/APIControllers/TextPageAPIController.php");
            $controller = new TextPageAPIController();
        } elseif (str_starts_with($request, "/api/images")) {
            require_once("controllers/APIControllers/ImageAPIController.php");
            $controller = new ImageAPIController();
        } elseif (str_starts_with($request, "/api/artists")) {
            require_once("controllers/APIControllers/Jazz/JazzArtistAPIController.php");
            $controller = new JazzArtistAPIController();
        } elseif (str_starts_with($request, "/api/addresses")) {
            require_once("controllers/APIControllers/AddressAPIController.php");
            $controller = new AddressAPIController();
        } elseif (str_starts_with($request, "/api/locations")) {
            require_once("controllers/APIControllers/LocationAPIController.php");
            $controller = new LocationAPIController();
        } elseif (str_starts_with($request, "/api/events")) {
            require_once("controllers/APIControllers/EventAPIController.php");
            $controller = new EventAPIController();
        } elseif (str_starts_with($request, "/api/tickettypes")) {
            require_once("controllers/APIControllers/TicketTypesAPIController.php");
            $controller = new TicketTypesAPIController();
        } elseif (str_starts_with($request, "/api/cart")) {
            require_once("controllers/APIControllers/CartAPIController.php");
            $controller = new CartAPIController();
        } elseif (str_starts_with($request, "/api/eventtypes")) {
            require_once("controllers/APIControllers/EventTypeAPIController.php");
            $controller = new EventTypeAPIController();
        } elseif (str_starts_with($request, "/api/pages")) {
            require_once("controllers/APIControllers/PagesAPIController.php");
            $controller = new PagesAPIController();
        } else {
            http_response_code(400);
            // send json
            header('Content-Type: application/json');
            echo json_encode(array("message" => "Unrecognized API request."));
            return;
        }

        $controller->initialize($request);
    }

    private function routeAdminPanels($request)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["user"])) {
            header("Location: /");
            return;
        }

        require_once("models/User.php");
        $user = unserialize($_SESSION['user']);

        if ($user->getUserType() > 2) {
            header("Location: /");
            return;
        }

        switch ($request) {
            case "/admin/editor":
                require("views/admin/editor.php");
                break;
            case "/admin/artists":
                require("views/admin/artists.php");
                break;
            case "/admin/jazz-events":
                require("views/admin/jazz-events.php");
                break;
            case "/admin/images":
                require("views/admin/images.php");
                break;
            case "/admin/locations":
                require("views/admin/locations.php");
                break;
            case "/admin/tickettypes":
                require("views/admin/tickettypes.php");
                break;
            case "/admin/passes":
                require("views/admin/passes.php");
                break;
            case "/admin/nav":
                require("views/admin/nav.php");
                break;
        }
    }

    private function routeAdminManage($request)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["user"])) {
            header("Location: /");
            return;
        }

        require_once("models/User.php");
        $user = unserialize($_SESSION['user']);

        if ($user->getUserType() > 2) {
            header("Location: /");
            return;
        }

        if ($user->getUserType() == 2 || $request == "/manageScanTicket") {
            require_once('views/employee/ticketScan.php');
            return;
        }

        switch ($request) {
            case "/manageUsers":
                require_once("controllers/UserController.php");
                $userController = new UserController();
                $userController->manageUsers();
                break;
            case "/manageImages":
                require("views/admin/manageImages.php");
                return;
            case "/manageTextPages":
            case "/manage":
                require("views/admin/manageTextPages.php");
                return;
            case "/manageTicketTypes":
                require("views/admin/manageTicketTypes.php");
                return;
            case "/managePasses":
                require("views/admin/managePasses.php");
                return;
            case "/manageNavBar":
                require("views/admin/manageNavBar.php");
                return;
            case "/manageDance":
            case "/manageDJs":
                require("views/admin/Dance management/manageDance.php");
                return;
            case "/manageRestaurants":
                require_once("controllers/RestaurantController.php");
                $restaurantController = new RestaurantController();
                $restaurantController->manageRestaurants();
                break;
            case "/manageJazz":
                require('views/admin/Jazz management/manageJazz.php');
                break;
            case "/manageHistory":
                require_once("controllers/HistoryController.php");
                $historyController = new HistoryController();
                $historyController->manageHistory();
                break;
        }
    }
}