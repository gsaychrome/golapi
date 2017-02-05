<?php
namespace Clab2\Golapi\Rest\Controller\Phalcon;
use Clab2\Application\Rest\Controller\Phalcon\PortalService;
use Clab2\Golapi\Business\Toolkit;
use Clab2\Golapi\Rest\Api\IGameService;


/**
 * REST service PHALCON implementation
 */
class GameService extends PortalService implements IGameService
{

    public function __construct($server, $config)
    {
        parent::__construct($server, $config);
        $this->map['post']["/{$this->getUrlBase()}/next"] = "next";
        $this->map['get']["/{$this->getUrlBase()}/init"] = "init";
    }

    /**
     * @return IMenuAdapter
     */
    protected function getAdapter()
    {
        return $this->getToolkit()->business->golapiGameControllerAdapter;
    }

    /**
     * @return string
     */
    protected function getUrlBase()
    {
        return "golapi/game";
    }

    /**
     * @return Toolkit
     */
    protected function getToolkit()
    {
        return Toolkit::getInstance();
    }

    public function nextAction()
    {
        $request = $this->getJsonRawBody(true);
        $space = $this->getToolkit()->golapiLivingSpaceAdapter->fetch($request);
        $space = $this->getToolkit()->golapiGameControllerAdapter->next($space);
        return $this->responseOk($this->toRest($space));
    }

    public function initAction()
    {
        $space = $this->getToolkit()->golapiLivingSpaceAdapter->createSpace(45,45);
        $space = $this->getToolkit()->golapiGameControllerAdapter->next($space);
        return $this->responseOk($this->toRest($space));
    }


}