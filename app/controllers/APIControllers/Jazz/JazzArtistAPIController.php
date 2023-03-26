<?php

require_once(__DIR__ . "/../APIController.php");
require_once(__DIR__ . "/../../../services/JazzArtistService.php");
require_once(__DIR__ . "/../../../models/Exceptions/MissingVariableException.php");

class JazzArtistAPIController extends APIController
{
    private $service;

    public function __construct()
    {
        $this->service = new JazzArtistService();
    }

    public function handleGetRequest($uri)
    {
        if (basename($uri) == "kinds") {
            echo json_encode($this->service->getArtistKinds());
            return;
        }

        if (is_numeric(basename($uri))) {
            echo json_encode($this->service->getById(basename($uri)));
            return;
        }

        $sort = $_GET["sort"] ?? "name";
        $filters = [];
        if (isset($_GET["kind"])) {
            $filters["kind"] = $_GET["kind"];
        }

        echo json_encode($this->service->getAll($sort, $filters));
    }

    public function handlePostRequest($uri)
    {
        $json = file_get_contents('php://input');

        $data = json_decode($json);

        if ($data == null) {
            echo json_encode(["error" => "Invalid JSON"]);
            return;
        }

        try {
            if (!isset($data->name)) {
                throw new MissingVariableException("Name is required");
            }
            $name = $data->name;
            $description = $this->getIfSet($data, "description");
            $recentAlbums = $this->getIfSet($data, "recentAlbums");
            $country = $this->getIfSet($data, "country");
            $genres = $this->getIfSet($data, "genres");
            $homepage = $this->getIfSet($data, "homepage");
            $facebook = $this->getIfSet($data, "facebook");
            $twitter = $this->getIfSet($data, "twitter");
            $instagram = $this->getIfSet($data, "instagram");
            $spotify = $this->getIfSet($data, "spotify");
            $images = $this->getIfSet($data, "images");
            $kindId = $this->getIfSet($data, "kindId");

            echo json_encode($this->service->insertArtist(
                $name,
                $description,
                $recentAlbums,
                $country,
                $genres,
                $homepage,
                $facebook,
                $twitter,
                $instagram,
                $spotify,
                $images,
                $kindId
            ));
        } catch (Throwable $e) {
            $this->sendErrorMessage($e->getMessage());
        }
    }

    private function getIfSet($data, $key)
    {
        if (isset($data->$key)) {
            return $data->$key;
        }

        return "";
    }

    public function handleDeleteRequest($uri)
    {
        if (is_numeric(basename($uri))) {
            $this->service->deleteById(basename($uri));
            $this->sendSuccessMessage("Artist deleted");
            return;
        }

        $this->sendErrorMessage("Invalid URI");
    }

    public function handlePutRequest($uri)
    {
        if (!is_numeric(basename($uri))) {
            $this->sendErrorMessage("Invalid URI");
            return;
        }

        $json = file_get_contents('php://input');

        $data = json_decode($json);

        if ($data == null) {
            echo json_encode(["error" => "Invalid JSON"]);
            return;
        }

        try {
            if (!isset($data->name)) {
                throw new MissingVariableException("Name is required");
            }
            $artistId = basename($uri);
            $name = $data->name;
            $description = $this->getIfSet($data, "description");
            $recentAlbums = $this->getIfSet($data, "recentAlbums");
            $country = $this->getIfSet($data, "country");
            $genres = $this->getIfSet($data, "genres");
            $homepage = $this->getIfSet($data, "homepage");
            $facebook = $this->getIfSet($data, "facebook");
            $twitter = $this->getIfSet($data, "twitter");
            $instagram = $this->getIfSet($data, "instagram");
            $spotify = $this->getIfSet($data, "spotify");
            $images = $this->getIfSet($data, "images");
            $kindId = $this->getIfSet($data, "kindId");

            echo json_encode($this->service->updateById(
                $artistId,
                $name,
                $description,
                $recentAlbums,
                $country,
                $genres,
                $homepage,
                $facebook,
                $twitter,
                $instagram,
                $spotify,
                $images,
                $kindId
            ));
        } catch (Throwable $e) {
            $this->sendErrorMessage($e->getMessage());
        }
    }
}
