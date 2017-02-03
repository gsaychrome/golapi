<?php

namespace Clab2\Golapi\Business\Api;

/**
 * Az élettér adapter interface
 */
interface ILivingSpaceAdapter
{
    /**
     * Létrehoz egy üres életteret
     * @param int $width Az élettés szélessége
     * @param int $height Az élettér magassága
     * @return ILivingSpace
     */
    public function createSpace($width=100, $height=100);
}