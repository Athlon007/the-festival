<?php

require_once("../Image.php");
require_once("Song.php");

class JazzArtist implements JsonSerializable
{
    private $id;
    private string $name;
    private string $description;
    private array $recentAlbums;
    private array $images;
    private string $country;
    private array $genres;
    private string $homepage;
    private string $facebook;
    private string $twitter;
    private string $instagram;
    private string $spotify;
    private array $songs;

    public function __construct($id, $name, $description, $images, $country, $genres, $homepage, $facebook, $twitter, $instagram, $spotify, $songs)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->images = $images;
        $this->country = $country;
        $this->genres = $genres;
        $this->homepage = $homepage;
        $this->facebook = $facebook;
        $this->twitter = $twitter;
        $this->instagram = $instagram;
        $this->spotify = $spotify;
        $this->songs = $songs;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($value)
    {
        $this->name = $value;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($value)
    {
        $this->description = $value;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function setImages($value)
    {
        $this->images = $value;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($value)
    {
        $this->country = $value;
    }

    public function getGenres()
    {
        return $this->genres;
    }

    public function setGenres($value)
    {
        $this->genres = $value;
    }

    public function getHomepage()
    {
        return $this->homepage;
    }

    public function setHomepage($value)
    {
        $this->homepage = $value;
    }

    public function getFacebook()
    {
        return $this->facebook;
    }

    public function setFacebook($value)
    {
        $this->facebook = $value;
    }

    public function getTwitter()
    {
        return $this->twitter;
    }

    public function setTwitter($value)
    {
        $this->twitter = $value;
    }

    public function getInstagram()
    {
        return $this->instagram;
    }

    public function setInstagram($value)
    {
        $this->instagram = $value;
    }

    public function getSpotify()
    {
        return $this->spotify;
    }

    public function setSpotify($value)
    {
        $this->spotify = $value;
    }

    public function getSongs()
    {
        return $this->songs;
    }

    public function setSongs($value)
    {
        $this->songs = $value;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'images' => $this->getImages(),
            'country' => $this->getCountry(),
            'genres' => $this->getGenres(),
            'homepage' => $this->getHomepage(),
            'facebook' => $this->getFacebook(),
            'twitter' => $this->getTwitter(),
            'instagram' => $this->getInstagram(),
            'spotify' => $this->getSpotify(),
            'songs' => $this->getSongs()
        ];
    }
}
