<?php

namespace Clab2\Golapi\Business\Traits;

/**
 * Implementációtól független definiciók és logika
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
    private static $properties = ['id','step', 'width', 'height', 'cells', 'name', 'description'];

    /**
     * @var int A mentett élettér azonosítója
     * @Id(name="id",strategy="INCREMENT")
     * @SWG\Property(example=1)
     */
    protected $id;

    /**
     * @var string A mentett élettér neve
     * @Field(type="string")
     * @Column(type="string")
     * @SWG\Property(example="Ez egy név")
     */
    protected $name;

    /**
     * @var string A mentett élettér leírása
     * @Field(type="string")
     * @Column(type="string")
     * @SWG\Property(example="Ez egy leírás")
     */
    protected $description;

    /**
     * @var int Az iterációk száma, amin az élettér már átesett
     * @Field(type="int")
     * @Column(type="integer")
     * @SWG\Property(example=10)
     */
    protected $step;

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
     * @var array Az élettél cellainformációi
     * @Field(type="raw")
     * @SWG\Property(example={{0,0,1,0,0},{0,1,1,0,0}})
     */
    protected $cells;

    /**
     * @param $cells
     */
    public function setCells($cells) {
        $this->cells = $cells;
        $this->step++;
        if(!empty($cells)) {
            $this->height = count($cells);
            if(!empty($cells[0])) {
                $this->width = count($cells[0]);
            }
        }
        return $this;
    }

}
