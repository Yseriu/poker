<?php

/**
 * Created by PhpStorm.
 * User: Yseriu
 * Date: 16/11/2015
 * Time: 19:17
 */

require_once('user.php');
require_once('player.php');
require_once('hand.php');

class table
{
    /** @var  PDO $pdo */
    public $pdo;

    public $id;
    public $nom;
    public $minMise;
    public $pot;
    public $cartes;
    public $players;

    public static $CARTESBASE = array('12', '13', '14', '15', '16', '17', '18', '19', '1A', '1B', '1C', '1D', '1E', '22', '23', '24', '25', '26', '27', '28', '29', '2A', '2B', '2C', '2D', '2E', '32', '33', '34', '35', '36', '37', '38', '39', '3A', '3B', '3C', '3D', '3E', '42', '43', '44', '45', '46', '47', '48', '49', '4A', '4B', '4C', '4D', '4E');

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
    
    public static function getAmount(PDO $pdo)
    {
    	$q = $pdo->query("SELECT * FROM 'tab'");
    	return $q->rowCount();
    }
    
    public static function getList(PDO $pdo)
    {
	    $ans = "#";
    	$q = $pdo->query("SELECT * FROM 'tab'");
    	$ans .= strval($q->rowCount());
    	$q->setFetchMode(PDO::FETCH_CLASS, 'table');
    	while ($t = $q->fetch())
    	{
    		$ans .= $t;
    	}
    	return $ans;
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
        $q = $this->pdo->prepare("SELECT * FROM player WHERE tabID=:id");
        $q->bindValue('id', $this->getId());
        $q->execute();
        while($e = $q->fetch())
        {
            array_push($this->players, player::get($this->getPdo(), $e['unixid'], $this->getId()));
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

    /**
     * @return int
     */
    public function getMinMise()
    {
        return $this->minMise;
    }

    /**
     * @param int $minMise
     */
    public function setMinMise($minMise)
    {
        $this->minMise = $minMise;
    }


    /**
     * Format
     *
     * # followed by the amount of players
     * #s followes by player names, as much as the amount of player given above
     * # followed by the min keb
     *
     * ends with new line \n
     * @return string
     */
    public function __toString()
    {
    	$ans = "";
    	$ans .= '#' . $this->getId();
    	$ans .= '#' . $this->getNom();
        $ans .= '#'. strval(sizeof($this->getPlayers()));
        foreach ($this->getPlayers() as $p)
        {
            /** @var $p player */
            $ans .= '#' . $p->getNom();
        }
        $ans .= '#' . strval($this->getMinMise());
        // $ans .= '#' . strval();
        return $ans . '\n';
    }


    public static function shuffle()
    {
        $shuffled = array();
        $notInside = self::$CARTESBASE;
        while ($notInside) {
            $x = rand(0, sizeof($notInside));
            array_push($shuffled, $notInside[$x]);
            array_splice($notInside, $x, 1);
        }
        return $shuffled;
    }

    public function compareHands($h1, $h2)
    {

    }
}
