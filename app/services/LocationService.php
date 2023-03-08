<?php

require_once(__DIR__ . "/../repositories/LocationRepository.php");
require_once(__DIR__ . "/AddressService.php");
require_once(__DIR__ . "/../models/Location.php");


class LocationService
{
    private LocationRepository $repo;
    private $addressService;

    public function __construct()
    {
        $this->repo = new LocationRepository();
        $this->addressService = new AddressService();
    }

    public function getAll(): array
    {
        return $this->repo->getAll();
    }

    public function getById($id): Location
    {
        return $this->repo->getById($id);
    }

    public function getLocationsByType(int $type): array
    {
        return $this->repo->getLocationsByType($type);
    }

    public function insertLocation($name, $streetName, $houseNumber, $postalCode, $city, $country, $locationType, $lon, $lat): Location
    {
        $address = $this->addressService->insertAddress($streetName, $houseNumber, $postalCode, $city, $country);

        $name = htmlspecialchars($name);
        $locationType = htmlspecialchars($locationType);
        $lon = htmlspecialchars($lon);
        $lat = htmlspecialchars($lat);

        $locationId = $this->repo->insertLocation($name, $address->getAddressId(), $locationType, $lon, $lat);
        return $this->getById($locationId);
    }

    public function updateLocation($locationId, $name, $streetName, $houseNumber, $postalCode, $city, $country, $locationType, $lon, $lat): Location
    {
        $locationId = htmlspecialchars($locationId);
        $name = htmlspecialchars($name);
        $locationType = htmlspecialchars($locationType);
        $lon = htmlspecialchars($lon);
        $lat = htmlspecialchars($lat);

        $address = $this->addressService->updateAddress($locationId, $streetName, $houseNumber, $postalCode, $city, $country);

        $this->repo->updateLocation($locationId, $name, $address->getAddressId(), $locationType, $lon, $lat);
        return $this->getById($locationId);
    }

    public function deleteLocation($locationId): void
    {
        $locationId = htmlspecialchars($locationId);
        $this->repo->deleteLocation($locationId);
    }

    const TOMTOM_API_KEY = "hhPEr4bmakfOBlVfPEsMhZWHNlmGt40L";

    public function fetchGeocoding($street, $buildingNumber, $postal, $city)
    {
        //https://api.tomtom.com/search/2/geocode/Zijlsingel 2, 2013 DN, Haarlem.json?key=hhPEr4bmakfOBlVfPEsMhZWHNlmGt40L
        $opts = array(
            'http' => array(
                'method' => "GET",
                'header' => "Content-Type: application/json"
            ),
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            )
        );

        $context = stream_context_create($opts);

        $address = urlencode($street . " " . $buildingNumber . ", " . $postal . " " . $city);
        $url = "https://api.tomtom.com/search/2/geocode/$address.json?key=" . self::TOMTOM_API_KEY;

        $response = file_get_contents($url, true, $context);
        $response = json_decode($response, true);

        // chekc if response is null
        if ($response == null) {
            throw new Exception("Invalid JSON");
        }

        $lat = $response['results'][0]['position']['lat'];
        $lon = $response['results'][0]['position']['lon'];

        return [
            "lat" => $lat,
            "lon" => $lon
        ];
    }
}
