<?php

require_once("Repository.php");
require_once("../models/Image.php");
class ImageRepository extends Repository
{
    private function imageBuilder($arr): array
    {
        $output = array();
        foreach ($arr as $row) {
            $id = $row["imageId"];
            $src = $row["src"];
            $alt = $row["alt"];
            $image = new Image($id, $src, $alt);

            array_push($output, $image);
        }
        return $output;
    }

    public function getImageById($id): ?Image
    {
        $sql = "SELECT imageId, src, alt FROM Images WHERE imageId = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $imageArray = $this->imageBuilder($stmt->fetchAll());
        return empty($imageArray) ? null : $imageArray[0];
    }

    public function getImagesForPageId($pageId): array
    {
        $sql = "SELECT i.imageId, i.src, i.alt FROM Images i
                INNER JOIN BannerImages bi ON i.imageId = bi.imageId
                WHERE bi.pageId = :pageId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":pageId", $pageId, PDO::PARAM_INT);
        $stmt->execute();
        return $this->imageBuilder($stmt->fetchAll());
    }

    public function getAll(): array
    {
        $sql = "SELECT imageId, src, alt FROM Images";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $this->imageBuilder($stmt->fetchAll());
    }

    public function removeImagesForPage($pageId): void
    {
        $sql = "DELETE FROM BannerImages WHERE pageId = :pageId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":pageId", $pageId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function setImagesForPage($pageId, $imageIds): void
    {
        $sql = "INSERT INTO BannerImages (pageId, imageId) VALUES (:pageId, :imageId)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":pageId", $pageId, PDO::PARAM_INT);
        foreach ($imageIds as $imageId) {
            $stmt->bindParam(":imageId", $imageId, PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    public function addImage($src, $alt): void
    {
        $sql = "INSERT INTO Images (src, alt) VALUES (:src, :alt)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":src", $src, PDO::PARAM_STR);
        $stmt->bindParam(":alt", $alt, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function removeImage($id): void
    {
        $sql = "DELETE FROM Images WHERE imageId = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateImage($id, $alt): void
    {
        $sql = "UPDATE Images SET alt = :alt WHERE imageId = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":alt", $alt, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function getImagesForArtistId($artistId): array
    {
        $sql = "SELECT i.imageId, i.src, i.alt FROM Images i
                INNER JOIN JazzArtistImage ai ON i.imageId = ai.imageId
                WHERE ai.artistId = :artistId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":artistId", $artistId, PDO::PARAM_INT);
        $stmt->execute();
        return $this->imageBuilder($stmt->fetchAll());
    }

    public function assignImageToArtist($artistId, $imageIds)
    {
        $this->removeImagesForArtist($artistId);

        $sql = "INSERT INTO JazzArtistImage (artistId, imageId) VALUES (:artistId, :imageId)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":artistId", $artistId, PDO::PARAM_INT);
        foreach ($imageIds as $imageId) {
            $stmt->bindParam(":imageId", $imageId, PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    public function removeImagesForArtist($artistId): void
    {
        $sql = "DELETE FROM JazzArtistImage WHERE artistId = :artistId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":artistId", $artistId, PDO::PARAM_INT);
        $stmt->execute();
    }
}
