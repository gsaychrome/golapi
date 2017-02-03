<?php

namespace Clab2\Golapi\Business\Api;

/**
 * A játék vezérlése
 */
interface IGameControllerAdapter
{
    /**
     * Kiszámmítja az élettér új állapotát
     * @param ILivingSpace $space Az élettér
     * @return ILivingSpace
     */
    public function next($space);
}