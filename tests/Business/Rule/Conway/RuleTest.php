<?php
namespace Clab2\Golapi\Tests\Business\Odm\Doctrine;
use Clab2\Golapi\Tests\Business\RuleTestCase;

/**
 * A conway féle implementáció tesztje
 */
Class RuleTest extends RuleTestCase
{
    protected $config = [
        'golapi' => [
            'business' => [
                'Rule' => [
                    'adapterType' => 'Coneway'
                ]
            ]
        ]
    ];

}

