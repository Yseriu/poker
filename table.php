<?php

/**
 * Created by PhpStorm.
 * User: Yseriu
 * Date: 16/11/2015
 * Time: 19:17
 */

require_once('user.php');
require_once('player.php');

class table
{
    /** @var  PDO $pdo */
    public $pdo;

    public $id;
    public $nom;
    public $pot;
    public $cartes;
    public $players;


    /**
     * @param PDO $pdo
     * @param int $id
     * @return table
     */
    public static function get(PDO $pdo, $id)
    {
        $q = $pdo->prepare("SELECT * FROM 'tab' WHERE id=:id");
        $q->bindValue('id', $id, PDO::PARAM_INT);
        $q->setFetchMode(PDO::FETCH_CLASS, 'table');
        $q->execute();
        $tab = $q->fetch();
        $tab->getPlayers();
        $tab->setPdo($pdo);
        return $tab;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPot()
    {
        return $this->pot;
    }

    /**
     * @param mixed $pot
     */
    public function setPot($pot)
    {
        $this->pot = $pot;
    }

    /**
     * @return mixed
     */
    public function getCartes()
    {
        return $this->cartes;
    }

    /**
     * @return table
     */
    public function getPlayers()
    {
        $this->players = array();
        $q = $this->pdo->prepare("SELECT * FROM players WHERE tabID=:id");
        $q->bindValue('id', $this->getId());
        $q->execute();
        while($e = $q->fetch())
        {
            array_push($this->players, user::get($this->pdo, $e['unixid']));
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * @param mixed $pdo
     */
    public function setPdo($pdo)
    {
        $this->pdo = $pdo;
    }

}