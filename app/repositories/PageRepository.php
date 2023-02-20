<?php

require_once("Repository.php");
require_once("../models/Page.php");
require_once("../models/TextPage.php");

class PageRepository extends Repository
{
    /**
     * Handles building of the page objects.
     * @param mixed $arr An array from the 'stmt->fetchAll()'.
     * @return array An array of the pages
     * (note: it can be empty, if criteria set by the previous matching was not met).
     */
    private function pageBuilder($arr): array
    {
        $output = array();
        foreach ($arr as $row) {
            $id = $row["id"];
            $title = $row["title"];
            $href = $row["href"];
            $location = $row["location"];
            $page = new Page($id, $title, $href, $location);

            array_push($output, $page);
        }
        return $output;
    }

    private function textPageBuilder($arr): array
    {
        $output = array();
        foreach ($arr as $row) {
            $id = $row["textPageId"];
            $title = $row["title"];
            $href = $row["href"];
            $text = $row["content"];
            $page = new TextPage($id, $title, $href, $text);

            array_push($output, $page);
        }
        return $output;
    }

    /**
     * Returns matching page, or null if nothing was found.
     * @param mixed $id Page's ID.
     * @return ?Page A requested page (or null).
     */
    public function getPageById($id): ?Page
    {
        $sql = "SELECT id, title, href, location FROM Pages WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $pageArray = $this->pageBuilder($stmt->fetchAll());
        return empty($pageArray) ? null : $pageArray[0];
    }

    /**
     * Returns all pages in the database.
     * @return array Array of pages.
     */
    public function getAll(): array
    {
        $sql = "SELECT id, title, href, location FROM Pages";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $this->pageBuilder($stmt->fetchAll());
    }

    /**
     * Returns a page with matching href, or null if one was not found.
     * @param mixed $href Href of the webpage.
     * @return ?Page A requested page (or null).
     */
    public function getPageByHref($href): ?Page
    {
        $sql = "SELECT id, title, href, location FROM Pages WHERE href = :href";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":href", $href, PDO::PARAM_STR);
        $stmt->execute();
        $pageArray = $this->pageBuilder($stmt->fetchAll());
        return empty($pageArray) ? null : $pageArray[0];
    }

    public function getTextPageByHref($href): ?TextPage
    {
        $sql = "SELECT tp.textPageId, tp.content, p.title, p.href, p.location "
            . "FROM TextPages tp JOIN Pages p ON p.id = tp.textPageId "
            . "WHERE p.href = :href";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":href", $href, PDO::PARAM_STR);
        $stmt->execute();
        $pageArray = $this->textPageBuilder($stmt->fetchAll());
        return empty($pageArray) ? null : $pageArray[0];
    }

    public function countTextPages($href): bool
    {
        $sql = "SELECT p.id, p.href FROM Pages p JOIN TextPages tp ON p.id = tp.textPageId WHERE p.href = :href";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":href", $href, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
