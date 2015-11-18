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
    public $mise;
    
    public static $COUCHE = 0;
    public static $PASSE = 1;
    public static $MISE = 2;
    public static $CHECK = 3;
    
    public function __construct__(array $data)
    {
    	parent::__construct__($data);
    	$this->setStatus(isset($data['status']) ? $data['status'] : player::COUCHE);
    }

    public function getPlayersAtTable(PDO $pdo, $tabId)
    {

    }


	public static function get(PDO $pdo, $uId, $tabId)
	{
		$u = parent::get($pdo, $uId);
		$q = $pdo->prepare("SELECT * FROM 'player' WHERE user=:user AND tab=:table");
		$q->bindValue('user', $u->getId());
		$q->bindValue('table', $tabId);
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