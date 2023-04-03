<?php

require_once("Repository.php");
require_once("../models/NavigationBarItem.php");

class NavigationBarItemRepository extends Repository
{
    /**
     * Builds an array of NavigationBarItem objects from the given array.
     * @param array $arr The array to build the NavigationBarItem objects from.
     * @return array The array of NavigationBarItem objects.
     */
    private function navBarItemBuilder(array $arr): array
    {
        require_once("PageRepository.php");
        $pageRepository = new PageRepository();

        $output = array();
        foreach ($arr as $row) {
            $id = $row["id"];
            $pageId = $row["pageId"];
            $displayOrder = $row["displayOrder"];

            $page = $pageRepository->getPageById($pageId);
            $children = $this->getChildrenOf($id);

            array_push($output, new NavigationBarItem($id, $page, $children, $displayOrder));
        }

        return $output;
    }

    /**
     * Returns all the navigation bar items that are not children of another navigation bar item.
     * @return array The navigation bar items that are not children of another navigation bar item.
     */
    public function getAll(): array
    {
        $sql = "SELECT nbi.id, nbi.pageId, nbi.order AS displayOrder "
            . "FROM NavigationBarItems nbi WHERE parentNavId IS NULL ORDER BY nbi.order";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $this->navBarItemBuilder($stmt->fetchAll());
    }

    /**
     * Returns all the children of the navigation bar item with the given id.
     * @param int $navBarItemId The id of the navigation bar item to return the children of.
     * @return array The children of the navigation bar item with the given id.
     */
    public function getChildrenOf(int $navBarItemId)
    {
        $sql = "SELECT nbi.id, nbi.pageId, nbi.order AS displayOrder "
            . "FROM NavigationBarItems nbi WHERE parentNavId = :navBarItemId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":navBarItemId", $navBarItemId, PDO::PARAM_INT);
        $stmt->execute();
        $output = $this->navBarItemBuilder($stmt->fetchAll());
        return $output;
    }

    /**
     * Returns the navigation bar item with the given id.
     * @param int $id The id of the navigation bar item to return.
     * @return NavigationBarItem The navigation bar item with the given id.
     */
    public function getById(int $id): NavigationBarItem
    {
        $sql = "SELECT nbi.id, nbi.pageId, nbi.order AS displayOrder FROM NavigationBarItems nbi WHERE nbi.id = :id ORDER BY nbi.order";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $output = $this->navBarItemBuilder($stmt->fetchAll());
        return $output[0];
    }

    public function clear()
    {
        $sql = "DELETE FROM NavigationBarItems";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        // We can also reset the auto increment value to 1.
        $sql = "ALTER TABLE NavigationBarItems AUTO_INCREMENT = 1";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
    }

    public function insert($pageId, $order): int
    {
        $sql = "INSERT INTO NavigationBarItems (pageId, `order`) VALUES (:pageId, :order)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":pageId", $pageId, PDO::PARAM_INT);
        $stmt->bindParam(":order", $order, PDO::PARAM_INT);
        $stmt->execute();

        return $this->connection->lastInsertId();
    }

    public function setParent($id, $parentId)
    {
        $sql = "UPDATE NavigationBarItems SET parentNavId = :parentId WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":parentId", $parentId, PDO::PARAM_INT);
        $stmt->bindParam(":id", $pageId, PDO::PARAM_INT);
        $stmt->execute();
    }
}
