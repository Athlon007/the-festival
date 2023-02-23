<?php

require_once(__DIR__ . "/APIController.php");
require_once(__DIR__ . "/../../services/PageService.php");

class TextPageAPIController extends APIController
{
    private $service;

    public function __construct()
    {
        $this->service = new PageService();
    }

    public function handleGetRequest($uri)
    {
        if (str_starts_with($uri, "/api/textpages")) {
            if (is_numeric(basename($uri))) {
                $page = $this->service->getTextPageById(basename($uri));
                if ($page == null) {
                    $this->sendErrorMessage("Page not found.", 404);
                    return;
                }
                echo json_encode($page);
                return;
            }

            $pages = $this->service->getAllTextPages();
            echo json_encode($pages);
        } else {
            $this->sendErrorMessage("Invalid request.");
        }
    }

    public function handlePutRequest($uri)
    {
        $data = json_decode(file_get_contents("php://input"));
        if ($data == null) {
            $this->sendErrorMessage("No data received.");
            return;
        }

        if (str_starts_with($uri, "/api/textpages") && is_numeric(basename($uri))) {
            if (!isset($data->title) || !isset($data->content) || !isset($data->images) || !isset($data->href)) {
                throw new Exception("Invalid data received.");
            }

            $this->service->updateTextPage(basename($uri), $data->title, $data->content, $data->images, $data->href);

            // get page
            $page = $this->service->getTextPageById(basename($uri));
            echo json_encode($page);
            return;
        }

        $this->sendErrorMessage("Invalid request.");
    }
}