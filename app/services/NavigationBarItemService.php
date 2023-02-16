<?php
require_once("../repositories/NavigationBarItemRepository.php");

class NavigationBarItemService
{
    private $navBarItemRepository;

    public function __construct()
    {
        $this->navBarItemRepository = new NavigationBarItemRepository();
    }

    /**
     * Returns all the navigation bar items that are not children of another navigation bar item.
     * @return array The navigation bar items that are not children of another navigation bar item.
     */
    public function getAll(): array
    {
        return $this->navBarItemRepository->getAll();
    }

    /**
     * Returns the navigation bar item with the given id.
     * @param int $id The id of the navigation bar item to return.
     * @return NavigationBarItem The navigation bar item with the given id.
     */
    public function getNavBarItemById(int $id): NavigationBarItem
    {
        return $this->navBarItemRepository->getById($id);
    }
}
