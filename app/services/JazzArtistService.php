<?php

require_once(__DIR__ . "/../repositories/JazzArtistRepository.php");
require_once("SongService.php");
require_once("ImageService.php");

class JazzArtistService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new JazzArtistRepository();
    }

    public function getAll(): array
    {
        return $this->repo->getAll();
    }

    public function getById($id): JazzArtist
    {
        $id = htmlspecialchars($id);
        return $this->repo->getById($id);
    }

    public function insertArtist($name, $description, $recentAlbums, $country, $genres, $homepage, $facebook, $twitter, $instagram, $spotify, $songs, $images): JazzArtist
    {
        $name = htmlspecialchars($name);
        $description = htmlspecialchars($description);
        $country = htmlspecialchars($country);
        $genres = htmlspecialchars($genres);
        $homepage = htmlspecialchars($homepage);
        $facebook = htmlspecialchars($facebook);
        $twitter = htmlspecialchars($twitter);
        $instagram = htmlspecialchars($instagram);
        $spotify = htmlspecialchars($spotify);

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
            $spotify
        );

        // Now, we insert the songs and images
        $songService = new SongService();
        $imageService = new ImageService();

        if (is_array($songs)) {
            foreach ($songs as $song) {
                $songService->assignSongToArtist($song->id, $artistId);
            }
        }

        if (is_array($images)) {
            foreach ($images as $image) {
                $imageService->assignImageToArtist($image->id, $artistId);
            }
        }

        return $this->getById($artistId);
    }

    public function deleteById($id)
    {
        $id = htmlspecialchars($id);
        $this->repo->deleteById($id);
    }

    public function updateById($artistId, $name, $description, $recentAlbums, $country, $genres, $homepage, $facebook, $twitter, $instagram, $spotify, $songs, $images): JazzArtist
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
            $spotify
        );

        // Now, we insert the songs and images
        $songService = new SongService();
        $imageService = new ImageService();

        if (is_array($songs)) {
            $songs = array();
        }
        foreach ($songs as $song) {
            $songService->assignSongToArtist($song->id, $artistId);
        }

        if (is_array($images)) {
            $images = array();
        }
        foreach ($images as $image) {
            $imageService->assignImageToArtist($image->id, $artistId);
        }

        return $this->getById($artistId);
    }
}
