<?php

namespace Clab2\Golapi\Rest\Api;

interface IGameService
{

    /**
     * @SWG\Post(
     *     path="/golapi/game/next",
     *     tags={"game"},
     *     summary="A játék egy következő állapotának kiszámítása",
     *     x={"methodName"="next", "group"="Golapi_Game"},
     *     @SWG\Parameter(
     *         description="A játéktér adatai",
     *         in="body",
     *         name="menu",
     *         required=true,
     *         schema=@SWG\Schema(ref="#/definitions/Golapi_LiveSpace")
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="A játék új adatai",
 *              @SWG\Items(ref="#/definitions/Golapi_LiveSpace")
     *     ),
     * )
     *
     */
    public function nextAction();

    /**
     * @SWG\Post(
     *     path="/golapi/game/init",
     *     tags={"game"},
     *     summary="A játék alapállapota",
     *     x={"methodName"="next", "group"="Golapi_Game"},
     *     @SWG\Response(
     *          response=200,
     *          description="A játék adatai",
     *              @SWG\Items(ref="#/definitions/Golapi_LiveSpace")
     *     ),
     * )
     *
     */
    public function initAction();

}