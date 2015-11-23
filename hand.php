<?php

/**
 * Created by PhpStorm.
 * User: Yseriu
 * Date: 22/11/2015
 * Time: 20:22
 */

class hand
{
    public $h;
    public $highest;

    public static $QUINTE_FLUSH_ROYAL = 0;
    public static $QUINTE_FLUSH = 1;
    public static $CARRE = 2;
    public static $FULL = 3;
    public static $FLUSH = 4;
    public static $QUINTE = 5;
    public static $BRELAN = 6;
    public static $DOUBLE_PAIRE = 7;
    public static $PAIRE = 8;
    public static $HIGHEST = 9;


    public function __construct($h)
    {
        $this->h = $h;
        $this->setHighest();
    }

    function setHighest()
    {
        $max = $this->getH()[0];
        foreach ($this->getH() as $c) {

            if ($max[1] < $c[1]) {
                $max = $c;
            }
        }
        $this->highest = $max;
        return $this;
    }

    /**
     * @param string $nb carte[1]
     * @param string $color
     * @return bool
     */
    function contains($nb, $color = 0)
    {
        foreach($this->h as $carte)
        {
            if ($carte[1] == $nb and ($color == '0' or $color == $carte[0])) return $carte;
        }
        return false;
    }

    /**
     * @param String $c Carte en deux caractères
     * @return null|string
     */
    public static function prevNum($c)
    {
        if($c[1] > '2' and $c[1] <= '9') $x = strval(intval($c[1])-1);
        elseif($c[1] == '2') return Null;
        elseif($c[1] == 'A') $x = '9';
        else $x = chr(ord($c[1])-1);
        return $c[0] . $x;
    }

    /**
     * @param bool|False $flush True if looking for Flush Quintes only
     * @return bool True if this hand is a quinte
     */
    function isQuinte($flush = False)
    {
        foreach($this->getH() as $carte)
        {
            if (!$carte[1] < '6')
            {
                $turn = True;
                for ($i = 0; $i < 4; $i++)
                {
                    $pre = self::prevNum($carte);
                    $carte = $flush ? $this->contains($pre[1], $pre[0]) : $this->contains($pre[1]);
                    if (!$carte) {
                        $turn = False;
                    }
                }
                if ($turn) return True;
            }
        }
        return False;
    }

    public function count($nb)
    {
        $ans = 0;
        if($this->contains($nb, '1')) $ans++;
        if($this->contains($nb, '2')) $ans++;
        if($this->contains($nb, '3')) $ans++;
        if($this->contains($nb, '4')) $ans++;
        return $ans;
    }

    public function isCarre()
    {
        foreach($this->getH() as $carte)
        {
            if($this->count($carte[1]) == 4) return True;
        }
        return False;
    }

    public function isPaire()
    {
        foreach($this->getH() as $carte)
        {
            if($this->count($carte[1]) == 2) return True;
        }
        return False;
    }

    public function isBrelan()
    {
        foreach($this->getH() as $carte)
        {
            if($this->count($carte[1]) == 3) return True;
        }
        return False;
    }

    public function isFull()
    {
        return $this->isBrelan() and $this->isPaire();
    }

    public function isFlush()
    {
        $types = [0, 0, 0, 0];
        foreach($this->getH() as $carte)
        {
            $types[$carte[0]-1]++;
        }
        return max($types) >= 5;
    }

    public function isDoublePaire()
    {
        if(!$this->isPaire()) return False;
        $sec = False;
        $counted = array();
        foreach($this->getH() as $carte)
        {
            if(!isset($counted[$carte[1]]) and $this->count($carte[1]) == 2)
            {
                if($sec) return True;
                else
                {
                    $counted[$carte[1]] = True;
                    $sec = True;
                }
            }
        }
        return False;

    }

    public function is()
    {
        if($this->isQuinte(True))
        {
            if($this->getHighest()[1] == 'E')
                return self::$QUINTE_FLUSH_ROYAL;
            else
                return self::$QUINTE_FLUSH;
        }
        elseif($this->isCarre())
        {
            return self::$CARRE;
        }
        elseif($this->isFull())
        {
            return self::$FULL;
        }
        elseif($this->isFlush())
        {
            return self::$FLUSH;
        }
        elseif($this->isQuinte())
        {
            return self::$QUINTE;
        }
        elseif($this->isBrelan())
        {
            return self::$BRELAN;
        }
        elseif($this->isDoublePaire())
        {
            return self::$DOUBLE_PAIRE;
        }
        elseif($this->isPaire())
        {
            return self::$PAIRE;
        }
        else
        {
            return self::$HIGHEST;
        }
    }

    public function sorted()
    {
        $ans = '';
        $arr = array_map(function($x){return $x[1];}, $this->getH());
        $mul = array();
        foreach($arr as $c)
        {
            $cnt = $this->count($c);
            if($cnt > 1 and strpos(implode('', $mul), $c) === False)
                $mul[$c] = $cnt;
        }
        arsort($mul);
        foreach($mul as $k => $c)
        {
            $ans .= str_repeat($k, $c);
        }
        rsort($arr);
        foreach($arr as $c)
        {
            if(strpos($ans, $c) === False)
                $ans .= $c;
        }
        return $ans;
    }

    /**
     * @return mixed
     */
    public function getH()
    {
        return $this->h;
    }

    /**
     * @return mixed
     */
    public function getHighest()
    {
        return $this->highest;
    }
}