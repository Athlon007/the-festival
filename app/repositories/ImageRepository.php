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
        $sql = "SELECT id, src, alt FROM Images WHERE id = :id";
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
}
