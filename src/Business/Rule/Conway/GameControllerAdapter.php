<?php

namespace Clab2\Golapi\Business\Rule\Conway;
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
        //$cells = $this->birth($cells,$space);
        //$cells = $this->death($cells,$space);
        $space->cells = $cells;
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
        }
        return $cells;
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
                if($nbs==3) {
                    $cells[$i][$j] = LivingSpace::CELL_LIVE;
                }
            }
        }
        return $cells;
    }

}