<?php

namespace Clab2\Golapi\Business\Odm\Doctrine;

use Clab2\Application\Business\Odm\Doctrine\Data;
use Clab2\Application\Business\Traits\PropertyTrait;
use Clab2\Golapi\Business\Api\ILivingSpace;
use Clab2\Golapi\Business\Traits\LivingSpaceTrait;

// Model annotations
use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;

/**
 * @Document(collection="clab_golapi__livingspace")
 */
class LivingSpace extends Data implements ILivingSpace
{

    use LivingSpaceTrait, PropertyTrait;

}