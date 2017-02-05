<?php

namespace Clab2\LivingSpace\Business\Odm\Doctrine;

use Clab2\Application\Business\Odm\Doctrine\Filter;
use Clab2\Application\Business\Traits\PropertyTrait;
use Clab2\LivingSpace\Business\Api\ILivingSpaceFilter;
use Clab2\LivingSpace\Business\Traits\LivingSpaceFilterTrait;

/**
 * Élettér szűrő
 */
class LivingSpaceFilter extends Filter implements ILivingSpaceFilter
{

    use LivingSpaceFilterTrait, PropertyTrait;
}