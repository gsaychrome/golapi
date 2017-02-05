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
        $livingSpace = $this->toolkit->business->golapiLivingSpaceAdapter->createSpace(200, 100);
        $this->assertNotNull($livingSpace);
        $this->assertInstanceOf('\\Clab2\\Golapi\\Business\\Api\\ILivingSpace', $livingSpace);
    }

    /**
     * Az élettér inicializálásának tesztelése
     */
    public function testCellInit()
    {
        $livingSpace = $this->toolkit->business->golapiLivingSpaceAdapter->createSpace(200, 100);
        // Ha üresen hozzuk létre, akkor az iterációk számát 0-ra állítjuk
        $this->assertEquals(0, $livingSpace->step);
        $livingSpace->cells = [
            [0, 0, 0],
            [0, 0, 0],
            [0, 0, 0]
        ];
        // Ha értéket adunk a celláknak, akkor automatikusan az 1-es lépésre kerülünk
        $this->assertEquals(1, $livingSpace->step);
    }

    /**
     * Lif fileok beolvasásának tesztelése
     */
    public function testLifParser()
    {
        $file = dirname(dirname(__DIR__)) . '/data/ACORN.LIF';
        $data = file_get_contents($file);
        $space = $this->toolkit->business->golapiLivingSpaceAdapter->parse($data);
        $cells = [
            [0, 1, 0, 0, 0, 0, 0],
            [0, 0, 0, 1, 0, 0, 0],
            [1, 1, 0, 0, 1, 1, 1]
        ];
        $this->assertNotNull($space);
        $this->assertInstanceOf('\\Clab2\\Golapi\\Business\\Api\\ILivingSpace', $space);
        $this->assertEquals(7, $space->width);
        $this->assertEquals(3, $space->height);
        $this->assertEquals($cells, $space->cells);

        $cells = [
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 1, 1, 0, 0, 1, 1, 1, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
        ];
        $livingSpace = $this->toolkit->business->golapiLivingSpaceAdapter->createSpace(15, 9);
        $space = $this->toolkit->business->golapiLivingSpaceAdapter->parse($data, $livingSpace);
        $this->assertEquals(15, $space->width);
        $this->assertEquals(9, $space->height);
        $this->assertEquals($cells, $space->cells);
    }

    public function testSaveAndGet()
    {
        $adapter = $this->toolkit->business->golapiLivingSpaceAdapter;
        $adapter->reset();

        $space = $adapter->createSpace(10, 10);
        $space->name = 'test';
        $space->cells = $cells = [
            [0, 1, 0, 0, 0, 0, 0],
            [0, 0, 0, 1, 0, 0, 0],
            [1, 1, 0, 0, 1, 1, 1]
        ];
        $id = $adapter->save($space);

        $adapter->clearCache();

        $space2 = $adapter->get($id);
        $this->assertEquals($space->id, $space2->id);
        $this->assertEquals($space->width, $space2->width);
        $this->assertEquals($space->height, $space2->height);
        $this->assertEquals($space->step, $space2->step);
        $this->assertEquals($space->cells, $space2->cells);
        $this->assertEquals($space->name, $space2->name);
    }

    public function testList()
    {
        $adapter = $this->toolkit->business->golapiLivingSpaceAdapter;
        $adapter->reset();

        $s = $adapter->createSpace(10,10);
        $s->name = 'test 1';
        $adapter->save($s);
        $s = $adapter->createSpace(20,20);
        $s->name = 'test 2';
        $adapter->save($s);
        $s = $adapter->createSpace(30,30);
        $s->name = 'test 3';
        $adapter->save($s);

        $adapter->clearCache();

        $list = $adapter->createFilter()->getResults(['id','name','savedOn']);
        $this->assertNotNull($list);
        $this->assertCount(3,$list);
        $this->assertEquals(1,$list[0]->id);
        $this->assertEquals(2,$list[1]->id);
        $this->assertEquals(3,$list[2]->id);
        $this->assertEquals('test 1',$list[0]->name);
        $this->assertEquals('test 2',$list[1]->name);
        $this->assertEquals('test 3',$list[2]->name);

    }

}
