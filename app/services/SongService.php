<?php

require_once("../repositories/SongRepository.php");

class SongService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new SongRepository();
    }

    public function getForArtistId($id): array
    {
        $id = htmlspecialchars($id);

        return $this->repo->getSongsForArtistId($id);
    }

    public function assignSongToArtist($songId, $artistId): void
    {
        $songId = htmlspecialchars($songId);
        $artistId = htmlspecialchars($artistId);

        $this->repo->assignSongToArtist($songId, $artistId);
    }
}
