<?php

namespace Clab2\Golapi\Business\Api;

/**
 * Az életjáték életterének leírása
 * @property int $id Adatbázis azonosító
 * @property int $step Az iterációk száma, amin az élettér már átesett
 * @property int $width Az élettér szélessége
 * @property int $height Az élettér magassága
 * @property int $name Az élettér neve
 * @property int $description Az élettér leírása
 * @property int[][] $cells Az élettér állapottere
 */
interface ILivingSpace
{
    /**
     * Üres cellák jelölése
     */
    const CELL_EMPTY = 0;
    /**
     * Élő cellák jelölése
     */
    const CELL_LIVE = 1;
}