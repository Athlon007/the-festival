<?php
require_once("APIController.php");
require_once(__DIR__ . '/../../services/PageService.php');

class PagesAPIController extends APIController
{
    private $pageService;

    public function __construct()
    {
        $this->pageService = new PageService();
    }


    public function handleGetRequest($uri)
    {
        $output = $this->pageService->getAll();
        echo json_encode($output);
    }
}
