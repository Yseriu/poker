<?php

/**
 * Created by PhpStorm.
 * User: Yseriu
 * Date: 16/11/2015
 * Time: 21:39
 */
class user
{
    public $id;
    public $unixId;
    public $nom;
    public $lastAct;
    public $solde;


    public static function get(PDO $pdo, $uid)
    {
        $q = $pdo->prepare("SELECT * FROM 'user' WHERE unixid=:id");
        $q->bindValue('id', $uid, PDO::PARAM_STR);
        $q->setFetchMode(PDO::FETCH_CLASS, 'user');
        $q->execute();
        return $q->fetch();
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
    public function getUnixId()
    {
        return $this->unixId;
    }

    /**
     * @param mixed $unixId
     */
    public function setUnixId($unixId)
    {
        $this->unixId = $unixId;
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
    public function getLastAct()
    {
        return $this->lastAct;
    }

    /**
     * @param mixed $lastAct
     */
    public function setLastAct($lastAct)
    {
        $this->lastAct = $lastAct;
    }

    /**
     * @return mixed
     */
    public function getSolde()
    {
        return $this->solde;
    }

    /**
     * @param mixed $solde
     */
    public function setSolde($solde)
    {
        $this->solde = $solde;
    }
}