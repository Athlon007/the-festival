<?php
require_once(__DIR__ . "/APIController.php");
require_once("../services/NavigationBarItemService.php");

class NavBarAPIController extends APIController
{
    private $navService;

    public function __construct()
    {
        $this->navService = new NavigationBarItemService();
    }

    public function handleGetRequest($uri)
    {
        // Make sure that only localhost can use this API.
        if (!parent::isLocalApiRequest()) {
            parent::sendErrorMessage("Access denied.");
            return;
        }

        $output = $this->navService->getAll();
        echo json_encode($output);
    }

    public function handlePostRequest($uri)
    {
        if (!$this->isLoggedInAsAdmin()) {
            $this->sendErrorMessage('You are not logged in as admin.', 401);
            return;
        }

        // Make sure that only localhost can use this API.
        if (!parent::isLocalApiRequest()) {
            parent::sendErrorMessage("Access denied.");
            return;
        }

        require_once(__DIR__ . '/../../services/PageService.php');
        $pageService = new PageService();

        $input = json_decode(file_get_contents("php://input"), true);

        $navBarItemsArray = array();
        $index = 0;
        foreach ($input as $i) {
            $index++;
            $page = $pageService->getPageById($i["page"]["id"]);
            $children = array();
            $childIndex = (int)((string)$index . '00');
            foreach ($i["children"] as $child) {
                $childIndex++;
                $childPage = $pageService->getPageById($child["page"]["id"]);
                $children[] = new NavigationBarItem(0, $childPage, array(), $childIndex);
            }
            $navBarItemsArray[] = new NavigationBarItem(0, $page, $children, $index);
        }

        $output = $this->navService->setNavbars($navBarItemsArray);
        echo json_encode($output);
    }
}
