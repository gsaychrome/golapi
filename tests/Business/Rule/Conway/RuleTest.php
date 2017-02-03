<?php
namespace Clab2\Golapi\Tests\Business\Odm\Doctrine;
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

}

