<?php
require_once(__DIR__ . "/APIController.php");
require_once(__DIR__ . "/../../services/ImageService.php");

class ImageAPIController extends APIController
{
    private ImageService $service;

    public function __construct()
    {
        $this->service = new ImageService();
    }

    public function handleGetRequest($uri)
    {
        if (isset($_GET["search"])) {
            $images = $this->service->search($_GET["search"]);
            echo json_encode($images);
            return;
        }

        if (is_numeric(basename($uri))) {
            $image = $this->service->getImageById(basename($uri));
            echo json_encode($image);
            return;
        }

        $images = $this->service->getAll();
        echo json_encode($images);
    }

    public function handleDeleteRequest($uri)
    {
        if (str_starts_with($uri, "/api/images") && is_numeric(basename($uri))) {
            $this->service->removeImage(basename($uri));
            return;
        }

        $this->sendErrorMessage("Invalid request.");
    }

    public function handlePutRequest($uri)
    {
        $data = json_decode(file_get_contents("php://input"));
        if ($data == null) {
            $this->sendErrorMessage("No data received.");
            return;
        }

        if (str_starts_with($uri, "/api/images") && is_numeric(basename($uri))) {
            if (!isset($data->alt)) {
                throw new Exception("Invalid data received.");
            }

            $this->service->updateImage(basename($uri), $data->alt);

            // get image
            $image = $this->service->getImageById(basename($uri));
            echo json_encode($image);
            return;
        }

        $this->sendErrorMessage("Invalid request.");
    }
}
?>