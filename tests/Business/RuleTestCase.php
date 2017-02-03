<?php
namespace Clab2\Golapi\Tests\Business;

use Clab2\Application\Tests\TestCase;
use Clab2\Golapi\Toolkit;

class RuleTestCase extends TestCase
{
    /**
     * @var Toolkit
     */
    protected $toolkit;

    /**
     * Ellenőrizzük, hogy létrehozható-e a szabályrendszer
     */
    public function testAdapters()
    {
		$this->assertNotNull($this->toolkit->business->golapiGameControllerAdapter);
		$this->assertInstanceOf('\\Clab2\\Golapi\\Business\\Api\\IGameControllerAdapter',
			$this->toolkit->business->golapiGameControllerAdapter);
    }

    /**
     * Ellenörizzük, hogy a szabályrendszer rendben lefut-e, és a visszakapott élettér megfelel-e az elvárásoknak
     */
    public function testNextGeneration()
    {
        $w = 10;
        $h = 10;
        $space = $this->toolkit->business->golapiLivingSpaceAdapter->createSpace($w, $h);
        $this->assertNotNull($space);
        $this->assertEquals(0,$space->step);
        $space = $this->toolkit->business->golapiGameControllerAdapter->next($space);
        // A visszatérési érték egy élettér implementáció
        $this->assertNotNull($space);
        $this->assertInstanceOf('\\Clab2\\Golapi\\Business\\Api\\ILivingSpace',$space);
        // Aminek a méretei megegyeznek a bemenő élettérrel
        $this->assertEquals(1,$space->step);
        $this->assertEquals($w,$space->width);
        $this->assertEquals($h,$space->height);
        // A cellákban megtaláljuk a megfelelő dimenziójú tömböt
        $this->assertNotNull($space->cells);
        $this->assertCount($h,$space->cells);
        foreach($space->cells as $row) {
            $this->assertCount($w,$row);
        }
        // A cellaváltozásokat a konkrét implementációban ellenőrizzük, mert az függhet az élettér szabályaitól
    }
}
