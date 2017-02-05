<?php
/**
 * A Golapi REST service interface swagger fejléce és a REST API egyszerűsített objektumainak definiciói
 */

use Swagger\Annotations as SWG;

/**
 * Swagger API info
 * @SWG\Swagger(
 *     host=REST_API_HOST,
 *      @SWG\Info(
 *          description="Clab2 Gol API",
 *          title="Clab2 Gol API",
 *          version="0.1.0",
 *          @SWG\Contact(email="gsay@chrome.hu")
 *      )
 * )
 */

/**
 * 		@SWG\Definition(
 * 			definition="Golapi_LoadingData",
 *          type="object",
 *          title="Golapi_LoadingData",
 *          description="A betöltés paraméterei",
 * 			@SWG\Property(property="name", type="string", description="A minta neve", example="ACORN.LIF"),
 * 			@SWG\Property(property="width", type="integer", description="Az élettér szélessége", example="120"),
 * 			@SWG\Property(property="height", type="integer", description="Az élettér magassága", example="80")
 * 		)
 */
