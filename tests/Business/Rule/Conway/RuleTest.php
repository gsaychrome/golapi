<?php
namespace Clab2\Golapi\Tests\Business\Odm\Doctrine;
use Clab2\Golapi\Business\Odm\Doctrine\LivingSpace;
use Clab2\Golapi\Tests\Business\RuleTestCase;

/**
 * A conway féle implementáció tesztje
 */
Class RuleTest extends RuleTestCase
{
    protected $config = [
        // Tetszőleges adatbázismodellel tesztelhető
        'mongo' => [
            'host' => 'localhost',
            'port' => 27017,
            'database' => 'clab2_golapi_doctrine'
        ],
        'golapi' => [
            'business' => [
                'GameController' => [
                    'adapterType' => 'Rule\\Conway'
                ]
            ]
        ]
    ];

    /**
     * Ellenörizzük, hogy a születések a szabályoknak megfelelőek-e
     */
    public function testBirth()
    {
        $space = $this->toolkit->business->golapiLivingSpaceAdapter->createSpace(5, 5);
        $space = $this->toolkit->business->golapiGameControllerAdapter->next($space);
        // Ebben a játékban az üresen indított szimuláció üres marad
        foreach($space->cells as $row) {
            foreach($row as $cell) {
                $this->assertEquals(LivingSpace::CELL_EMPTY,$cell);
            }
        }
        $in = [
            [ 0, 0, 0, 0, 0],
            [ 0, 1, 1, 0, 0],
            [ 0, 1, 0, 0, 0],
            [ 0, 0, 0, 0, 0],
            [ 0, 0, 0, 0, 0],
        ];
        $out = [
            [ 0, 0, 0, 0, 0],
            [ 0, 1, 1, 0, 0],
            [ 0, 1, 1, 0, 0],
            [ 0, 0, 0, 0, 0],
            [ 0, 0, 0, 0, 0],
        ];
        $space->cells = $in;
        $space = $this->toolkit->business->golapiGameControllerAdapter->next($space);
        $this->assertEquals($out,$space->cells);
    }

    /**
     * Ellenörizzük, hogy az elhalálozások a szabályoknak megfelelőek-e
     */
    public function testDeath()
    {
        $space = $this->toolkit->business->golapiLivingSpaceAdapter->createSpace(5, 5);
        // itt nem hal meg senki
        $in = [
            [ 0, 0, 0, 0, 0],
            [ 0, 1, 1, 0, 0],
            [ 0, 1, 0, 0, 0],
            [ 0, 0, 0, 0, 0],
            [ 0, 0, 0, 0, 0],
        ];
        $out = [
            [ 0, 0, 0, 0, 0],
            [ 0, 1, 1, 0, 0],
            [ 0, 1, 1, 0, 0],
            [ 0, 0, 0, 0, 0],
            [ 0, 0, 0, 0, 0],
        ];
        $space->cells = $in;
        $space = $this->toolkit->business->golapiGameControllerAdapter->next($space);
        $this->assertEquals($out,$space->cells);
        $in = [
            [ 0, 0, 0, 0, 0],
            [ 0, 1, 1, 1, 0],
            [ 0, 1, 1, 0, 0],
            [ 0, 0, 0, 0, 0],
            [ 0, 0, 0, 0, 0],
        ];
        $out = [
            [ 0, 0, 1, 0, 0],
            [ 0, 1, 0, 1, 0],
            [ 0, 1, 0, 1, 0],
            [ 0, 0, 0, 0, 0],
            [ 0, 0, 0, 0, 0],
        ];
        $space->cells = $in;
        $space = $this->toolkit->business->golapiGameControllerAdapter->next($space);
        $this->assertEquals($out,$space->cells);

    }

}

