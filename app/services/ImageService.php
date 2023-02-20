<?php
require_once("../repositories/ImageRepository.php");
require_once("../models/Exceptions/ImageNotFoundException.php");
require_once("../models/Image.php");
require_once("../models/Page.php");

class ImageService
{
    private $imageRepository;

    public function __construct()
    {
        $this->imageRepository = new ImageRepository();
    }

    public function getImageById($id): ?Image
    {
        $image = $this->imageRepository->getImageById($id);
        if ($image == null) {
            throw new ImageNotFoundException();
        }
        return $image;
    }

    public function getAll(): array
    {
        return $this->imageRepository->getAll();
    }

    public function setImagesForPage($pageId, $imageIds): void
    {
        $cleanedImagesArray = array();
        foreach ($imageIds as $image) {
            array_push($cleanedImagesArray, htmlspecialchars($image));
        }

        // First we must delete old associations.
        $this->removeImagesForPage($pageId);

        $this->imageRepository->setImagesForPage($pageId, $cleanedImagesArray);
    }

    public function removeImagesForPage($pageId): void
    {
        $this->imageRepository->removeImagesForPage($pageId);
    }
}
