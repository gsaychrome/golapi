<?php

namespace Clab2\Golapi\Rest\Api;

interface ILivingSpaceService
{

    /**
     * @SWG\Post(
     *     path="/golapi/space/load",
     *     tags={"space"},
     *     summary="Egy példa minta betöltése",
     *     x={"methodName"="load", "group"="Golapi_LivingSpace"},
     *     @SWG\Parameter(
     *         description="A betöltés paraméterei",
     *         in="body",
     *         name="space",
     *         required=false,
     *         schema=@SWG\Schema(ref="#/definitions/Golapi_LoadingData")
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="A játék új adatai",
 *              @SWG\Items(ref="#/definitions/Golapi_LivingSpace")
     *     ),
     * )
     *
     */
    public function loadAction();

    /**
     * @SWG\Get(
     *     path="/golapi/space/samples",
     *     tags={"space"},
     *     summary="Az elérhető minta példák nevei",
     *     x={"methodName"="samples", "group"="Golapi_LivingSpace"},
     *     @SWG\Response(
     *          response=200,
     *          description="A példa minták nevei",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(type="string")
     *          )
     *     ),
     * )
     *
     */
    public function samplesAction();

    /**
     * @SWG\Get(
     *     path="/golapi/space/saved",
     *     tags={"space"},
     *     summary="Az elmentett életterek listája",
     *     x={"methodName"="saved", "group"="Golapi_LivingSpace"},
     *     @SWG\Response(
     *          response=200,
     *          description="Az életterek listájának kivonatos adatai",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(type="ref="#/definitions/Golapi_RestListLivingSpace")
     *          )
     *     ),
     * )
     *
     */
    public function savedAction();

    /**
     * @SWG\Get(
     *     path="/golapi/space/get/{id}",
     *     tags={"space"},
     *     summary="Az elmentett élettér adatai",
     *     x={"methodName"="get", "group"="Golapi_LivingSpace"},
     *     @SWG\Parameter(
     *         description="Az élettér azonosítója",
     *         format="int64",
     *         in="path",
     *         name="id",
     *         required=true,
     *         type="integer"
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="Az élettér adatai",
     *              @SWG\Items(ref="#/definitions/Golapi_LivingSpace")
     *     ),
     * )
     * Előkeres egy konkrét életteret az azonosítója alapján
     */
    public function getAction($id);

    /**
     * @SWG\Post(
     *     path="/golapi/space/save",
     *     tags={"space"},
     *     summary="Egy élettér elmentése",
     *     x={"methodName"="save", "group"="Golapi_LivingSpace"},
     *     @SWG\Parameter(
     *         description="A betöltés paraméterei",
     *         in="body",
     *         name="space",
     *         required=false,
     *         schema=@SWG\Schema(ref="#/definitions/Golapi_LivingSpace")
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="A játék új adatai",
     *              @SWG\Items(ref="#/definitions/Golapi_LivingSpace")
     *     ),
     * )
     * Elment egy életteret a megadott néven
     */
    public function saveAction();
}