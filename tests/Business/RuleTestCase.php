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

}
