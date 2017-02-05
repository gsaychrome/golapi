<?php
namespace Clab2\Golapi\Tests\Business;

use Clab2\Application\Tests\TestCase;
use Clab2\Golapi\Toolkit;

class AdapterTestCase extends TestCase
{
    /**
     * @var Toolkit
     */
    protected $toolkit;

    /**
     * Ellenőrizzük, hogy létrehozható-e minden adapter
     */
    public function testAdapters()
    {
        $this->assertNotNull($this->toolkit->business->golapiLivingSpaceAdapter);
        $this->assertInstanceOf('\\Clab2\\Golapi\\Business\\Api\\ILivingSpaceAdapter',
            $this->toolkit->business->golapiLivingSpaceAdapter);
    }

    /**
     * Ellenőrizzük, hogy létrehozható-e minden az interface-ben szereplő objektum
     */
    public function testObjects()
    {
        $livingSpace = $this->toolkit->business->golapiLivingSpaceAdapter->createSpace(200,100);
        $this->assertNotNull($livingSpace);
        $this->assertInstanceOf('\\Clab2\\Golapi\\Business\\Api\\ILivingSpace',$livingSpace);
    }

    /**
     * Az élettér inicializálásának tesztelése
     */
    public function testCellInit() {
        $livingSpace = $this->toolkit->business->golapiLivingSpaceAdapter->createSpace(200,100);
        // Ha üresen hozzuk létre, akkor az iterációk számát 0-ra állítjuk
        $this->assertEquals(0,$livingSpace->step);
        $livingSpace->cells = [
            [0,0,0],
            [0,0,0],
            [0,0,0]
        ];
        // Ha értéket adunk a celláknak, akkor automatikusan az 1-es lépésre kerülünk
        $this->assertEquals(1,$livingSpace->step);
    }

    /**
     * Lif fileok beolvasásának tesztelése
     */
    public function testLifParser() {
        $file = dirname(dirname(__DIR__)).'/data/ACORN.LIF';
        $data = file_get_contents($file);
        $space = $this->toolkit->business->golapiLivingSpaceAdapter->parse($data);
        $cells = [
            [0,1,0,0,0,0,0],
            [0,0,0,1,0,0,0],
            [1,1,0,0,1,1,1]
        ];
        $this->assertNotNull($space);
        $this->assertInstanceOf('\\Clab2\\Golapi\\Business\\Api\\ILivingSpace',$space);
        $this->assertEquals(7,$space->width);
        $this->assertEquals(3,$space->height);
        $this->assertEquals($cells,$space->cells);

        $cells = [
            [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,1,0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,1,0,0,0,0,0,0,0],
            [0,0,0,0,1,1,0,0,1,1,1,0,0,0,0],
            [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]
        ];
        $livingSpace = $this->toolkit->business->golapiLivingSpaceAdapter->createSpace(15,9);
        $space = $this->toolkit->business->golapiLivingSpaceAdapter->parse($data, $livingSpace);
        $this->assertEquals(15,$space->width);
        $this->assertEquals(9,$space->height);
        $this->assertEquals($cells,$space->cells);
    }
}
