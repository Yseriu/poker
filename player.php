<?php

/**
 * Created by PhpStorm.
 * User: Yseriu
 * Date: 16/11/2015
 * Time: 21:46
 */
class player extends user
{

    public $hand;
    public $status;
    public $tabId;

    public function getPlayersAtTable(PDO $pdo, $tabId)
    {

    }




    /**
     * @return mixed
     */
    public function getHand()
    {
        return $this->hand;
    }

    /**
     * @param mixed $hand
     */
    public function setHand($hand)
    {
        $this->hand = $hand;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getTabId()
    {
        return $this->tabId;
    }

    /**
     * @param mixed $tabId
     */
    public function setTabId($tabId)
    {
        $this->tabId = $tabId;
    }
}