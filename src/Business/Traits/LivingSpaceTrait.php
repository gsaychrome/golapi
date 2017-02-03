<?php

namespace Clab2\Golapi\Business\Traits;

use Clab2\Application\Business\Api\IData;

/**
 * @SWG\Definition(definition="Golapi_LivingSpace",title="Golapi_LivingSpace",
 *  allOf={
 *      @SWG\Schema(
 *       ref="#/definitions/Application_Data"
 *      )
 *  }
 *)
 */
trait LivingSpaceTrait
{
    private static $properties = ['width', 'height', 'cells'];

    /**
     * @var int Az élettér szélessége
     * @Field(type="int")
     * @Column(type="integer")
     * @SWG\Property(example=200)
     */
    protected $width;

    /**
     * @var int Az élettér magassága
     * @Field(type="int")
     * @Column(type="integer")
     * @SWG\Property(example=100)
     */
    protected $height;

    /**
     * @var int[][] Az élettél cellainformációi
     * @Field(type="raw")
     * @SWG\Property(example={{0,0,1,0,0},{0,1,1,0,0}})
     */
    protected $cells;

}
