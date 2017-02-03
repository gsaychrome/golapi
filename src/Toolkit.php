<?php

namespace Clab2\Golapi;

/**
 * Class Toolkit
 * @property Business\Toolkit $business
 */
class Toolkit extends \Clab2\Application\Toolkit
{
    /**
     * @return Toolkit|\Clab2\Application\Toolkit
     */
    public static function getInstance()
    {
        return parent::getInstance();
    }

}
