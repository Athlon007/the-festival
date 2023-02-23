<?php
require_once(__DIR__ . "/APIController.php");

class NavBarAPIController extends APIController{
    public function handleGetRequest($uri)
    {
        try {
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                switch ($uri) {
                    case "/api/nav":
                        // Make sure that only localhost can use this API.
                        if (!$this->isLocalApiRequest()) {
                            $this->sendErrorMessage("Access denied.");
                            return;
                        }
                        require_once(__DIR__ . "/../services/NavigationBarItemService.php");
                        $navService = new NavigationBarItemService();
                        $output = $navService->getAll();
                        header('Content-Type: application/json');
                        echo json_encode($output);
                        break;
                    default:
                        parent::sendErrorMessage("Invalid API Request");
                        break;
                }
            }
        } 
        catch (Exception $ex) {
            parent::sendErrorMessage($ex->getMessage());
        }
    }
}