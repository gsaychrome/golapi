<?php
namespace Clab2\Golapi\Tests\Business\Odm\Doctrine;

use Clab2\Golapi\Tests\Business\AdapterTestCase;

/**
 * A doctrine implementációk tesztje
 */
Class AdapterTest extends AdapterTestCase
{
    protected $config = [
                'mongo' => [
                    'host' => 'localhost',
                    'port' => 27017,
                    'database' => 'clab2_golapi_doctrine_test'
                ],
    ];

}

