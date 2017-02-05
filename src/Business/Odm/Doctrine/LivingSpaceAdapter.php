<?php

namespace Clab2\Golapi\Business\Odm\Doctrine;

use Clab2\Application\Exception;
use Clab2\Golapi\Business\Api\ILivingSpace;
use Clab2\Golapi\Business\Api\ILivingSpaceAdapter;

/**
 * A modulok adatkezelő műveleteit leíró interface
 */
class LivingSpaceAdapter extends \Clab2\Application\Business\Odm\Doctrine\Adapter implements ILivingSpaceAdapter
{
    /**
     * @return LivingSpace
     */
    public function create()
    {
        return new LivingSpace($this);
    }

    /**
     * @param int $width
     * @param int $height
     * @return ILivingSpace
     */
    public function createSpace($width = 100, $height = 100)
    {
        $space = $this->create();
        $space->width = $width;
        $space->height = $height;
        $space->step = 0;
        return $space;
    }

    /**
     * @param string $lif
     * @param ILivingSpace $space
     * @return ILivingSpace
     */
    public function parse($lif, $space = null)
    {
        // TODO: szétbontani olvasható részekre

        if ($space == null) {
            $space = $this->createSpace(0,0);
        }
        $lines = explode("\n", $lif);
        $cells = [];
        $xoffset = 0;
        $yoffset = 0;
        $minwidth = 0;
        $minheight = 0;
        foreach ($lines as $line) {
            $sch = substr($line, 0, 1);
            switch ($sch) {
                // Leíró sorok feldolgozása
                case '#':
                    $ctrl = substr($line, 0, 2);
                    switch ($ctrl) {
                        // File formátum azonosítás
                        case '#L':
                            // Egyenlőre csak az 1.05-öt kezeljük
                            if (chop($line) != "#Life 1.05") {
                                throw new Exception("Unknown life file format");
                            }
                            // TODO: file formátom azonosítás
                            break;
                        // Leíró mezők
                        case '#D':
                            // TODO: leíró mezők feldolgozása
                            break;
                        // Szabályok kezelése
                        case '#N':
                        case '#R':
                            // Egyenlőre csak a klasszikus Conway játékszabályokat fogadjuk el
                            if (chop($line) != "#N" && chop($line) != "#R 23/3") {
                                throw new Exception("Unknown life rules");
                            }
                            // TODO: élettér szabályok változtatása
                            break;

                        case '#P':
                            $data = explode(" ", chop($line));
                            $xoffset = (int)$data[1];
                            $yoffset = (int)$data[2];
                            break;

                    }
                    break;
                // adatsorok feldolgozása
                default:
                    $data = chop($line);
                    $data = str_replace('.', '0', $data);
                    $data = str_replace('*', '1', $data);
                    if (strlen($line) && preg_match('/^[01]*$/', $data)) {
                        $data = str_split($data);
                        $row = [];
                        foreach ($data as $d) {
                            $row[] = (int)$d;
                        }
                        $cells[] = $row;
                        $minheight++;
                        $minwidth = max($minheight, count($row));
                    }
                    break;
            }
        }
        // Kiegészítjük a csonka sorokat
        if (!empty($cells)) {
            for ($i = 0; $i < count($cells); $i++) {
                if ($minwidth - count($cells[$i]) > 0) {
                    $cells[$i] = array_values(array_merge(
                        $cells[$i],
                        array_fill(0, $minwidth - count($cells[$i]), 0)
                    ));
                }
            }
        }

        $minwidth = ceil($minwidth/2) + abs($xoffset);
        $minheight = ceil($minheight/2) + abs($yoffset);
        if($space->width<$minwidth) {
            $space->width = $minwidth;
        }
        $xo = floor($space->width / 2) + $xoffset;
        if($space->height<$minwidth) {
            $space->height=$minheight;
        }
        $yo = floor($space->height /  2) + $yoffset;

        $scells = [];
        for($i=0;$i<$space->height;$i++) {
            $scells[$i] = array_fill(0,$space->width,0);
            $ii = $i-$yo;
            if($ii>=0 && $ii<count($cells)) {
                for($j=0;$j<count($cells[$ii]);$j++) {
                    $scells[$i][$j+$xo] = $cells[$ii][$j];
                }
            }
        }

        $space->cells = $scells;


        return $space;
    }


}