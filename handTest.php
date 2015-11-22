<?php

/**
 * Created by PhpStorm.
 * User: Yseriu
 * Date: 22/11/2015
 * Time: 20:50
 */
require_once('hand.php');
echo '<meta charset="utf-8">';

//Highest
$hand = new hand(['1E', '1D', '1C', '1B', '1A', '25', '38']);
$hand->getHighest() == '1E' or die ('Erreur Highest');

//PrevNum
hand::prevNum('13') == '12' or die ('Erreur Prev Num 3 -> 2');
hand::prevNum('2E') == '2D' or die ('Erreur Prev Num E -> D');
hand::prevNum('3A') == '39' or die ('Erreur Prev Num A -> 9');
hand::prevNum('42') == Null or die ('Erreur Prev Num 2 -> Null');

// Contains
$arr = ['1E', '1D', '1C', '1B', '1A', '25', '38'];
$hand = new hand(['1E', '1D', '1C', '1B', '1A', '25', '38']);
$hand->contains('D') or die ('Erreur Contains D');
$hand->contains('D', '1') or die ('Erreur Contains 1D');
!$hand->contains('4') or die ('Erreur !Contains 4');
foreach ($arr as $c)
{
    $hand->contains($c[1], $c[0]) or die ('Erreur Contains');
}

// Count
$hand = new hand(['19', '18', '17', '16', '15', '14', '33']);
$hand->count('9') == 1 or die('Erreur Count Expected 1');
$hand = new hand(['27', '37', '17', '16', '15', '14', '47']);
$hand->count('7') == 4 or die('Erreur Count Expected 4');

// Quinte Flush
$hand = new hand(['19', '18', '17', '16', '15', '14', '33']);
$hand->isQuinte(True) or die('C\'était une quinte Flush 19');
$hand = new hand(['1E', '1D', '1C', '1B', '1A', '25', '38']);
$hand->isQuinte(True) or die('C\'était une quinte Flush 1E');
$hand = new hand(['1E', '1D', '14', '1B', '1A', '25', '38']);
!$hand->isQuinte(True) or die('C\'était pas une quinte Flush !');
$hand = new hand(['1E', '38', '1A', '25', '1C', '1B', '1D']);
$hand->isQuinte(True) or die('C\'était une quinte Flush 1E mélangée');

// CARRE
$hand = new hand(['19', '18', '17', '16', '15', '14', '33']);
!$hand->isCarre() or die('C\'était une quinte Flush 19, pas un carre');
$hand = new hand(['27', '37', '17', '16', '15', '14', '47']);
$hand->isCarre() or die('C\'était un Carre 7');

// Full
$hand = new hand(['27', '37', '17', '16', '15', '14', '47']);
!$hand->isFull() or die('C\'était un Carre 7, pas un full');
$hand = new hand(['24', '37', '2B', '16', '17', '14', '47']);
$hand->isFull() or die('C\'était un Full');

// Quinte
$hand = new hand(['19', '18', '17', '16', '15', '14', '33']);
$hand->isQuinte() or die('C\'était une quinte (Flush) 19');
$hand = new hand(['27', '37', '17', '16', '15', '14', '47']);
!$hand->isFull() or die('C\'était un Carre 7, pas une quinte');
$hand = new hand(['19', '28', '27', '46', '15', '2B', '3E']);
$hand->isQuinte() or die('C\'était une quinte 19');

// Flush
$hand = new hand(['1E', '1C', '1A', '16', '15', '14', '47']);
$hand->isFlush() or die('C\'était un flush');
$hand = new hand(['27', '37', '17', '16', '15', '14', '47']);
!$hand->isFlush() or die('C\'était un Carre 7, pas un flush');

// Double Paire
$hand = new hand(['1A', '2A', '3B', '4B', '15', '14', '47']);
$hand->isDoublePaire() or die('C\'était une double paire');
$hand = new hand(['1A', '22', '3B', '4B', '15', '14', '47']);
!$hand->isDoublePaire() or die('C\'était une paire simple');

// Paire
$hand = new hand(['1A', '2A', '3B', '4B', '15', '14', '47']);
$hand->isPaire() or die('C\'était une double paire, donc une paire');
$hand = new hand(['1A', '22', '3B', '4B', '15', '14', '47']);
$hand->isPaire() or die('C\'était une paire');

$hand = new hand(['1E', '38', '1A', '25', '1C', '1B', '1D']);
$hand->sorted() == 'EDCBA85' or die('Erreur Sorted 1');
$hand = new hand(['27', '37', '17', '16', '15', '14', '47']);
$hand->sorted() == '7777654' or die('Erreur Sorted 2');

echo 'Tests Passés avec succès';
