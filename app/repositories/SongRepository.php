<?php

require_once("Repository.php");
require_once("../models/Jazz/Song.php");

class SongRepository extends Repository
{
    private function buildSong($arr): array
    {
        $output = array();
        foreach ($arr as $row) {
            $songId = $row["songId"];
            $name = htmlspecialchars_decode($row["name"]);
            $length = htmlspecialchars_decode($row["length"]);
            $href = htmlspecialchars_decode($row["href"]);

            $song = new Song($songId, $name, $length, $href);

            array_push($output, $song);
        }

        return $output;
    }

    public function getSongsForArtistId($artistId): array
    {
        $sql = "SELECT songId, name, length, href FROM Songs WHERE artistId = :artistId";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":artistId", $artistId);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $songs = $this->buildSong($result);
        return $songs;
    }

    public function assignSongToArtist($songId, $artistId)
    {
        // Clean up old assignments.
        $this->clearSongsForArtist($artistId);

        $sql = "INSERT INTO ArtistSongs (artistId, songId) VALUES (:artistId, :songId)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":artistId", $artistId);
        $statement->bindParam(":songId", $songId);
        $statement->execute();
    }

    public function clearSongsForArtist($artistId)
    {
        $sql = "DELETE FROM ArtistSongs WHERE artistId = :artistId";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":artistId", $artistId);
        $statement->execute();
    }
}
