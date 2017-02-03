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
}
