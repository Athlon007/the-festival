<?php

require_once("Repository.php");
require_once("ImageRepository.php");
require_once("../models/Music/Artist.php");
require_once("../models/Music/ArtistKind.php");

class JazzArtistRepository extends Repository
{
    private $imageRepo;

    public function __construct()
    {
        parent::__construct();
        $this->imageRepo = new ImageRepository();
    }

    private function buildJazzArtist($arr): array
    {
        $output = array();
        foreach ($arr as $row) {
            $artistId = $row["artistId"];
            $name = htmlspecialchars_decode($row["name"]);
            $description = htmlspecialchars_decode($row["description"]);
            $genres = htmlspecialchars_decode($row["genres"]);
            $country = htmlspecialchars_decode($row["country"]);

            $homepage = $this->readIfSet($row, "homepageUrl");
            $facebook = $this->readIfSet($row, "facebookUrl");
            $twitter = $this->readIfSet($row, "twitterUrl");
            $instagram = $this->readIfSet($row, "instagramUrl");
            $spotify = $this->readIfSet($row, "spotifyUrl");
            $recentAlbums = $this->readIfSet($row, "recentAlbums");

            $images = $this->imageRepo->getImagesForArtistId($artistId);

            $artistKind = $this->getArtistKindById($row["artistKindId"]);

            $artist = new Artist(
                $artistId,
                $name,
                $description,
                $images,
                $country,
                $genres,
                $homepage,
                $facebook,
                $twitter,
                $instagram,
                $spotify,
                $recentAlbums,
                $artistKind
            );

            array_push($output, $artist);
        }

        return $output;
    }

    private function readIfSet($row, $colName)
    {
        if (isset($row[$colName])) {
            return htmlspecialchars_decode($row[$colName]);
        } else {
            return "";
        }
    }

    /**
     * Returns all artists.
     */
    public function getAll($sort): array
    {
        $sql = "SELECT artistId, name, description, recentAlbums, genres, country, homepageUrl, facebookUrl, twitterUrl, instagramUrl, spotifyUrl, recentAlbums, artistKindId "
            . "FROM JazzArtists";

        switch ($sort) {
            case "name":
                $sql .= " ORDER BY name";
                break;
            case "name_desc":
                $sql .= " ORDER BY name DESC";
                break;
            default:
                $sql .= " ORDER BY artistId";
                break;
        }

        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->buildJazzArtist($result);
    }

    /**
     * Returns the artist with the given id.
     */
    public function getById($id): Artist
    {
        $sql = "SELECT artistId, name, description, recentAlbums, genres, country, homepageUrl, facebookUrl, twitterUrl, instagramUrl, spotifyUrl, recentAlbums, artistKindId "
            . "FROM JazzArtists WHERE artistId = :id";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":id", $id);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $artists = $this->buildJazzArtist($result);
        return $artists[0];
    }

    /**
     * Inserts the given artist into the database.
     */
    public function insert(
        $name,
        $description,
        $recentAlbums,
        $genres,
        $country,
        $homepageUrl,
        $facebookUrl,
        $twitterUrl,
        $instagramUrl,
        $spotifyUrl,
        $artistKindId
    ): int {
        $sql = "INSERT INTO JazzArtists "
            . "(name, description, recentAlbums, genres, country, homepageUrl, facebookUrl, twitterUrl, instagramUrl, spotifyUrl) "
            . "VALUES (:name, :description, :recentAlbums, :genres, :country, :homepageUrl, :facebookUrl, :twitterUrl, :instagramUrl, :spotifyUrl, :artistKindId)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":name", $name);
        $statement->bindParam(":description", $description);
        $statement->bindParam(":recentAlbums", $recentAlbums);
        $statement->bindParam(":genres", $genres);
        $statement->bindParam(":country", $country);
        $statement->bindParam(":homepageUrl", $homepageUrl);
        $statement->bindParam(":facebookUrl", $facebookUrl);
        $statement->bindParam(":twitterUrl", $twitterUrl);
        $statement->bindParam(":instagramUrl", $instagramUrl);
        $statement->bindParam(":spotifyUrl", $spotifyUrl);
        $statement->bindParam(":artistKindId", $artistKindId);
        $statement->execute();

        return $this->connection->lastInsertId();
    }

    public function deleteById($artistId)
    {
        $sql = "DELETE FROM JazzArtists WHERE artistId = :artistId";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":artistId", $artistId);
        $statement->execute();
    }

    public function update(
        $artistId,
        $name,
        $description,
        $recentAlbums,
        $genres,
        $country,
        $homepageUrl,
        $facebookUrl,
        $twitterUrl,
        $instagramUrl,
        $spotifyUrl,
        $artistKindId
    ) {
        $sql = "UPDATE JazzArtists SET "
            . "name = :name, "
            . "description = :description, "
            . "recentAlbums = :recentAlbums, "
            . "genres = :genres, "
            . "country = :country, "
            . "homepageUrl = :homepageUrl, "
            . "facebookUrl = :facebookUrl, "
            . "twitterUrl = :twitterUrl, "
            . "instagramUrl = :instagramUrl, "
            . "spotifyUrl = :spotifyUrl, "
            . "artistKindId = :artistKindId "
            . "WHERE artistId = :artistId";

        $statement = $this->connection->prepare($sql);
        $statement->bindParam(":artistId", $artistId);
        $statement->bindParam(":name", $name);
        $statement->bindParam(":description", $description);
        $statement->bindParam(":recentAlbums", $recentAlbums);
        $statement->bindParam(":genres", $genres);
        $statement->bindParam(":country", $country);
        $statement->bindParam(":homepageUrl", $homepageUrl);
        $statement->bindParam(":facebookUrl", $facebookUrl);
        $statement->bindParam(":twitterUrl", $twitterUrl);
        $statement->bindParam(":instagramUrl", $instagramUrl);
        $statement->bindParam(":spotifyUrl", $spotifyUrl);
        $statement->bindParam(":artistKindId", $artistKindId);
        $statement->execute();
    }

    private function buildArtistKinds($arr): array
    {
        $output = [];
        foreach ($arr as $row) {
            $id = $row["id"];
            $name = $row["name"];
            $output[] = new ArtistKind($id, $name);
        }

        return $output;
    }

    private function getArtistKindById($id): ArtistKind
    {
        $sql = "SELECT id, name FROM ArtistKinds WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $this->buildArtistKinds($stmt->fetchAll())[0];
    }

    public function getArtistKinds(): array
    {
        $sql = "SELECT id, name FROM ArtistKinds";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        return $this->buildArtistKinds($stmt->fetchAll());
    }
}
