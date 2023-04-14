<?php

require_once("../models/Exceptions/UploadException.php");
require_once("../services/ImageService.php");

class UploaderController
{
    private $imageService;

    public function __construct()
    {
        $this->imageService = new ImageService();
    }

    public function start($request)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->performPost($request);
        }
    }

    private function performPost($request)
    {
        try {
            // Only admins can upload images
            require_once(__DIR__ . "/../models/User.php");
            $user = unserialize($_SESSION['user']);

            if ($user->getUserType() > 1) {
                throw new UploadException("You are not authorized to upload images.");
            }


            switch ($request) {
                case "/uploader/upload-image":
                    $this->uploadImage();
                    $this->redirectToImages("Image uploaded successfully!");
                    break;
                case "/uploader/remove-image":
                    $this->removeImage();
                    $this->redirectToImages("Image removed successfully!");
                    break;
                default:
                    $this->redirectToImages("", "Invalid action.");
                    break;
            }
        } catch (Throwable $e) {
            Logger::write($e);
            $this->redirectToImages("", "Something went wrong. Unable to upload image.");
        }
    }

    private function uploadImage(): void
    {
        $file = $_FILES["image"];
        $alt = $_POST["alt"];

        if ($file["error"] != 0) {
            switch ($file["error"]) {
                case 1:
                    throw new UploadException("File is too large. Max size is " . ini_get("upload_max_filesize") . "B");
                    break;
                default: // 4
                    throw new UploadException("Error uploading file. ");
                    break;
            }
        }

        $this->imageService->addImage($file, $alt);
    }

    private function removeImage(): void
    {
        $id = $_POST["id"];
        $this->imageService->removeImage($id);
    }

    private function redirectToImages($message = "", $errors = ""): void
    {
        $get = "";
        if ($message != "") {
            $get = "?message=" . $message;
        }

        if ($errors != null) {
            if ($get != "") {
                $get .= "&";
            } else {
                $get .= "?";
            }
            $get .= "errors=" . $errors;
        }

        // make GET html-friendly.
        $get = str_replace(" ", "%20", $get);

        header("Location: /admin/images" . $get);
    }
}
