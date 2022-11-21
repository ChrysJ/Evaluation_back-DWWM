<?php
require_once __DIR__ . '/../helpers/database/Connexion.php';

class Links
{
    // --------------------------------------------------------------------------------------------------
    // ----------------------------------ATTRIBUTS------------------------------------------------
    // --------------------------------------------------------------------------------------------------
    private int $_link_id;
    private string $_title;
    private string $_url;

    // --------------------------------------------------------------------------------------------------
    // ----------------------------------CONSTRUCT-----------------------------------------------
    // --------------------------------------------------------------------------------------------------
    // Method construct qui s'appel automatiquement a L'instanciation de la class
    public function __construct(string $title, string $url)
    {
        $this->_title = $title;
        $this->_url = $url;
        $this->pdo = Connexion::getInstance();
    }


    // -------------------------------------------------------------------------------------------------
    // ------------------------------------------ELEM EXIST----------------------------------------
    // -------------------------------------------------------------------------------------------------
    // ID EXIST
    public static function readId(int $id): bool|object
    {
        $pdo = Connexion::getInstance();
        $sql = 'SELECT `link_id` FROM `links` WHERE `link_id` = :id ;';
        $sth = $pdo->prepare($sql);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetch();
    }

    // URL EXIST
    public static function readUrl(string $url): bool|object
    {
        $pdo = Connexion::getInstance();
        $sql = 'SELECT `url` FROM `links` WHERE `url` = :url ;';
        $sth = $pdo->prepare($sql);
        $sth->bindValue(':url', $url);
        $sth->execute();
        return $sth->fetch();
    }

    // -------------------------------------------------------------------------------------------------
    // ------------------------------------------CRUD-----------------------------------------------
    // -------------------------------------------------------------------------------------------------
    // ---------------------------------------
    // -------------------CREATE
    // ---------------------------------------
    /** retourne true si la requéte s'est bien exécuté / Sinon false
     * @return bool
     */
    public function create(): bool
    {
        $sql = 'INSERT INTO `links`(`title`, `url`) VALUES (:title, :url);';
        $sth = $this->pdo->prepare($sql);
        $sth->bindValue(':title', $this->getTitle());
        $sth->bindValue(':url', $this->getUrl());
        if ($sth->execute()) {
            return ($sth->rowCount() == 1) ? true : false;
        }
    }

    // ---------------------------------------------
    // -------------------UPDATE
    // ---------------------------------------------
    /** retourne true si la requéte s'est bien exécuté / Sinon false
     * @param int $id
     * 
     * @return bool
     */
    public function update(int $id): bool
    {
        $sql = 'UPDATE `links` SET 
        `title` = :title, 
        `url` =  :url
        WHERE `link_id` = :id ;';
        $sth = $this->pdo->prepare($sql);
        $sth->bindValue(':title', $this->getTitle());
        $sth->bindValue(':url', $this->getUrl());
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        if ($sth->execute()) {
            return ($sth->rowCount() > 0) ? true : false;
        }
    }

    // ------------------------------------------
    // -------------------READ All
    // ------------------------------------------
    /** retorune un tableau d'objet des différents élément de la table LINKS
     * @return array
     */
    public static function readAll(): array
    {
        $pdo = Connexion::getInstance();
        $sql = 'SELECT * FROM `links`;';
        $sth = $pdo->query($sql);
        return $sth->fetchAll();
    }

    // ----------------------------------------
    // -------------------READ
    // ----------------------------------------
    /** retourne un objet
     * @param int $id
     * 
     * @return object
     */
    public static function read(int $id): object | bool
    {
        $pdo = Connexion::getInstance();
        $sql = 'SELECT * FROM `links`
        WHERE `link_id` = :id';
        $sth = $pdo->prepare($sql);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        return ($sth->execute()) ? $sth->fetch() : false;
    }

    // ---------------------------------------------
    // -------------------DELETE
    // ---------------------------------------------
    /** Supprime l'élément qui a l'id donnée sinon false
     * @param int $id
     * 
     * @return bool
     */
    public static function delete(int $id): bool
    {
        $pdo = Connexion::getInstance();
        $sql = 'DELETE FROM `links` WHERE `link_id` = :id';
        $sth = $pdo->prepare($sql);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        if ($sth->execute()) {
            return ($sth->rowCount() == 1) ? true : false;
        }
        return false;
    }

    // ------------------------------------------
    // -------------------GETTER / SETTER
    // ------------------------------------------
    // ----------------------------
    // -------ID
    // ----------------------------
    public function getLinkId(): int

    {
        return $this->_link_id;
    }

    public function setLinkId(int $_link_id): void
    {
        $this->_link_id = $_link_id;
    }
    // ----------------------------
    // -------TITLE
    // ----------------------------
    public function getTitle(): string
    {
        return $this->_title;
    }

    public function setTitle(string $title): void
    {
        $this->_title = $title;
    }
    // ----------------------------
    // -------URL
    // ----------------------------
    public function getUrl(): string

    {
        return $this->_url;
    }

    public function seturl(string $url): void
    {
        $this->_url = $url;
    }
}
