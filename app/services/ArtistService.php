<?php

require_once(__DIR__ . "/../repositories/ArtistRepository.php");
require_once("ImageService.php");
require_once(__DIR__ . "/../models/Exceptions/InvalidVariableException.php");

class ArtistService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new ArtistRepository();
    }

    public function getAll($sort, $filters): array
    {
        return $this->repo->getAll($sort, $filters);
    }

    public function getById($id): ?Artist
    {
        $id = htmlspecialchars($id);
        return $this->repo->getById($id);
    }

    public function insertArtist($name, $description, $recentAlbums, $country, $genres, $homepage, $facebook, $twitter, $instagram, $spotify, $images, $artistKindId): Artist
    {
        if (empty($name)) {
            throw new InvalidVariableException("Artist name is required.");
        }

        $name = htmlspecialchars($name);
        $description = htmlspecialchars($description);
        $country = htmlspecialchars($country);
        $genres = htmlspecialchars($genres);
        $homepage = htmlspecialchars($homepage);
        $facebook = htmlspecialchars($facebook);
        $twitter = htmlspecialchars($twitter);
        $instagram = htmlspecialchars($instagram);
        $spotify = htmlspecialchars($spotify);
        $recentAlbums = htmlspecialchars($recentAlbums);
        $artistKindId = htmlspecialchars($artistKindId);

        $artistId = $this->repo->insert(
            $name,
            $description,
            $recentAlbums,
            $genres,
            $country,
            $homepage,
            $facebook,
            $twitter,
            $instagram,
            $spotify,
            $artistKindId
        );

        // Now, we insert the songs and images
        $imageService = new ImageService();

        if (is_array($images)) {
            $imageService->assignImagesToArtist($artistId, $images);
        }

        return $this->getById($artistId);
    }

    public function deleteById($id)
    {
        $id = htmlspecialchars($id);
        $this->repo->deleteById($id);
    }

    public function updateById($artistId, $name, $description, $recentAlbums, $country, $genres, $homepage, $facebook, $twitter, $instagram, $spotify, $images, $artistKindId): Artist
    {
        $artistId = htmlspecialchars($artistId);
        $name = htmlspecialchars($name);
        $description = htmlspecialchars($description);
        $country = htmlspecialchars($country);
        $genres = htmlspecialchars($genres);
        $homepage = htmlspecialchars($homepage);
        $facebook = htmlspecialchars($facebook);
        $twitter = htmlspecialchars($twitter);
        $instagram = htmlspecialchars($instagram);
        $spotify = htmlspecialchars($spotify);
        $recentAlbums = htmlspecialchars($recentAlbums);
        $artistKindId = htmlspecialchars($artistKindId);

        $this->repo->update(
            $artistId,
            $name,
            $description,
            $recentAlbums,
            $genres,
            $country,
            $homepage,
            $facebook,
            $twitter,
            $instagram,
            $spotify,
            $artistKindId
        );

        // Now, we insert the songs and images
        $imageService = new ImageService();

        if (!is_array($images)) {
            $images = array();
        }
        $imageService->assignImagesToArtist($artistId, $images);

        return $this->getById($artistId);
    }

    public function getArtistKinds()
    {
        return $this->repo->getArtistKinds();
    }
}
