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
    public function createSpace($width=100, $height=100)
    {
        $space = $this->create();
        $space->width = $width;
        $space->height = $height;
        $space->step = 0;
        return $space;
    }

}