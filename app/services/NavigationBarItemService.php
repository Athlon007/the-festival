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
        $id = htmlspecialchars($id);
        return $this->navBarItemRepository->getById($id);
    }

    public function setNavbars(array $navbars): array
    {
        // First, we must clear the database of all the navigation bar items.
        $this->navBarItemRepository->clear();

        // Then, we must add the new navigation bar items.
        foreach ($navbars as $navbar) {
            $navbar->getPage()->setId(htmlspecialchars($navbar->getPage()->getId()));
            $navbar->setOrder(htmlspecialchars($navbar->getOrder()));

            $id = $this->navBarItemRepository->insert($navbar->getPage()->getId(), $navbar->getOrder());

            // If the navigation bar item has children, we must add them as well.
            foreach ($navbar->getChildren() as $child) {
                $childId = $this->navBarItemRepository->insert($child->getPage()->getId(), $child->getOrder());
                $this->navBarItemRepository->setParent($childId, $id);
            }
        }

        // Cool, we're done! Return an array with the new navigation bar items.
        return $this->getAll();
    }
}
