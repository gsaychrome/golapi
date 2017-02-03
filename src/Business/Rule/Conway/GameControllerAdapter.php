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
        $this->init($space);
        $ncells = $this->birth($space);
        $ocells = $this->death($space);
        // Mergeljük azokat akik nem haltak ki vagy most születtek
        for($i=0;$i<$space->height;$i++) {
            for ($j = 0; $j < $space->width; $j++) {
                $cells[$i][$j] = $ncells[$i][$j] == LivingSpace::CELL_LIVE || $ocells[$i][$j] == LivingSpace::CELL_LIVE
                    ? LivingSpace::CELL_LIVE : LivingSpace::CELL_EMPTY;
            }
        }
        $space->cells = $cells;
        return $space;
    }

    /**
     * Inicializálja az életteret, amennyiben szükséges. Ha teljesen üres, akkor létrehoz egy üres mátrixot
     * @param ILivingSpace $space
     * @return int[][]
     */
    protected function init($space) {
        if(empty($space->cells)) {
            $cells = [];
            for($i=0;$i<$space->height;$i++) {
                for ($j = 0; $j < $space->width; $j++) {
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
     * @param ILivingSpace $space
     * @return int[][] $cells
     */
    protected function birth($space) {
        $cells = [];
        for($i=0;$i<$space->height;$i++) {
            $cells[$i] = array_fill(0,$space->width,LivingSpace::CELL_EMPTY);
            for($j=0;$j<$space->width;$j++) {
                // Ha üres a cella
                if($cells[$i][$j]==LivingSpace::CELL_EMPTY) {
                    // A szomszédokat a játékvezérlőnek kell megszámlálnia, mivel az is változhat vezérlőként, hogy
                    // a határokon hogy viselkedik a cella
                    $nbs = $this->countNeightbours($i, $j, $space->cells);
                    // Születés, ha 3 szomszéd van
                    if ($nbs == 3) {
                        $cells[$i][$j] = LivingSpace::CELL_LIVE;
                    }
                }
                else {
                    $cells[$i][$j] = LivingSpace::CELL_EMPTY;
                }
            }
        }
        return $cells;
    }

    /**
     * @param ILivingSpace $space
     * @return int[][] $cells
     */
    protected function death($space) {
        $cells = [];
        for($i=0;$i<$space->height;$i++) {
            $cells[$i] = array_fill(0,$space->width,LivingSpace::CELL_EMPTY);
            for($j=0;$j<$space->width;$j++) {
                // A szomszédokat a játékvezérlőnek kell megszámlálnia, mivel az is változhat vezérlőként, hogy
                // a határokon hogy viselkedik a cella
                $nbs = $this->countNeightbours($i,$j,$space->cells);
                // Halál, ha 2-nél kevesebb vagy 3-nál több szomszéd van
                if($nbs<2 || $nbs>3) {
                    $cells[$i][$j] = LivingSpace::CELL_EMPTY;
                }
                else {
                    // Ha van élő akkor az túléli
                    $cells[$i][$j] = $space->cells[$i][$j];
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
                // Ha nem önmagunkat nézzük
                if($oi!=0||$oj!=0) {
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