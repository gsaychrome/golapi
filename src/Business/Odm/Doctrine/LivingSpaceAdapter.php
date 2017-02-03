<?php

namespace Clab2\Golapi\Business\Odm\Doctrine;

use Clab2\Golapi\Business\Api\ILivingSpace;
use Clab2\Golapi\Business\Api\ILivingSpaceAdapter;

/**
 * A modulok adatkezelő műveleteit leíró interface
 */
class LivingSpaceAdapter extends \Clab2\Application\Business\Odm\Doctrine\Adapter implements ILivingSpaceAdapter
{
    /**
     * @param int $width
     * @param int $height
     * @return ILivingSpace
     */
    public function createSpace($width=100, $height=100)
    {
        $space = new LivingSpace($this);
        $space->width = $width;
        $space->height = $height;
        return $space;
    }
}