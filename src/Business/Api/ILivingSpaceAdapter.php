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

    /**
     * Beolvas egy ILivingSpace objektumot a kapott asszociatív tömb adataiból
     * @param array $inputs
     * @param ILivingSpace $data
     * @return ILivingSpace
     */
    public function fetch($inputs, $data = null);

    /**
     * Lif adatformátum parsolása. Ha csak üres adatokat kap egy olyan élettérrel tér vissza, amibe pontosan belefér
     * a minta. Ha a második paraméterben kap egy életteret, akkor annak a közepére helyezi a mintát.
     * @param string $lif A lif file tartalma
     * @param ILivingSpace $data
     * @return ILivingSpace
     */
    public function parse($lif, $space=null);

}