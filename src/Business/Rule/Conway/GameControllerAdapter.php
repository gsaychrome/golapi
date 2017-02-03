<?php

namespace Clab2\Golapi\Business\Rule\Conway;
use Clab2\Application\Exception;
use Clab2\Golapi\Business\Api\IGameControllerAdapter;
use Clab2\Golapi\Business\Api\ILivingSpace;
use Clab2\Golapi\Business\Odm\Doctrine\LivingSpace;

/**
 * A játékszabályok Conway féle implementációja
 */
class GameControllerAdapter implements IGameControllerAdapter
{
    /**
     * @param ILivingSpace $space
     */
    public function next($space)
    {
        $cells = $this->init($space);
        $cells = $this->birth($cells,$space);
        //$cells = $this->death($cells,$space);
        $space->cells = $cells;
        $space->step++;
        return $space;
    }

    /**
     * Inicializálja az életteret, amennyiben szükséges. Ha teljesen üres, akkor létrehoz egy üres mátrixot
     * @param $space
     * @return int[][]
     */
    protected function init($space) {
        if(!$space->step) {
            $cells = [];
            for($i=0;$i<$space->height;$i++) {
                for ($j = 0; $j < $space->height; $j++) {
                    $cells[$i][$j] = LivingSpace::CELL_EMPTY;
                }
            }
            return $cells;
        }
        else {
            return $space->cells;
        }
    }

    /**
     * @param int[][] $cells
     * @param ILivingSpace $space
     * @return int[][] $cells
     */
    protected function birth($cells,$space) {
        for($i=0;$i<$space->height;$i++) {
            for($j=0;$j<$space->height;$j++) {
                // A szomszédokat a játékvezérlőnek kell megszámlálnia, mivel az is változhat vezérlőként, hogy
                // a határokon hogy viselkedik a cella
                $nbs = $this->countNeightbours($i,$j,$space->cells);
                // Születés, ha 3 szomszéd van
                if($nbs==3) {
                    $cells[$i][$j] = LivingSpace::CELL_LIVE;
                }
            }
        }
        return $cells;
    }

    /**
     * Megszámolja egy cella élő szomszédjait
     * @param int $top Offset a bal felső sarokból lefele
     * @param int $left Offset a bal felső sarokból jobbra
     * @param int[][] $cells A cellákat tartalmazó mátrix
     * @return int Az élő szomszédok száma
     */
    protected function countNeightbours($top, $left, $cells) {
        $cnt = 0;
        for($oi=-1;$oi<=1;$oi++) {
            for($oj=-1;$oj<=1;$oj++) {
                if($oi==0&&$oj==0) {
                    // Önmagunkat nem számoljuk
                    break;
                }
                else {
                    $i = $top+$oi;
                    $j = $left+$oj;
                    // Ha a viszgálat átlép a határon
                    if($i<0 || $j<0 || $i>count($cells)-1 || $j>count($cells[$i])-1) {
                        $status = $this->getBoundaryCondition($i,$j);
                    }
                    else {
                        $status = $cells[$i][$j];
                    }
                    if($status==LivingSpace::CELL_LIVE) {
                        $cnt++;
                    }
                }
            }
        }
        return $cnt;
    }

    /**
     * A játék határfeltételei. Ebben a játékban a határon túl minden cella üres;
     * @param int $i Offset a bal felső sarokból lefele
     * @param int $j Offset a bal felső sarokból jobbra
     * @return int A határon túli cella állapota
     */
    protected function getBoundaryCondition($i, $j) {
        return LivingSpace::CELL_EMPTY;
    }
}