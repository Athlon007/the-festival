<?php
require_once("../repositories/ImageRepository.php");
require_once("../models/Exceptions/ImageNotFoundException.php");
require_once("../models/Image.php");

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
}
