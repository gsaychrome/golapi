<?php
namespace Clab2\Golapi\Rest\Controller\Phalcon;

use Clab2\Application\Rest\Controller\Phalcon\PortalService;
use Clab2\Golapi\Business\Toolkit;
use Clab2\Golapi\Rest\Api\ILivingSpaceService;


/**
 * REST service PHALCON implementation
 */
class LivingSpaceService extends PortalService implements ILivingSpaceService
{

    public function __construct($server, $config)
    {
        parent::__construct($server, $config);
        $this->map['post']["/{$this->getUrlBase()}/next"] = "load";
        $this->map['get']["/{$this->getUrlBase()}/samples"] = "samples";
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
        return "golapi/space";
    }

    /**
     * @return Toolkit
     */
    protected function getToolkit()
    {
        return Toolkit::getInstance();
    }

    public function loadAction()
    {
        // TODO: hibakezelés
        $request = $this->getJsonRawBody(true);
        $name = $request['name'];
        $width = (int)$request['width'];
        $height = (int)$request['height'];
        $data = file_get_contents(dirname(dirname(dirname(dirname(__DIR__)))).'/data/'.$name);
        $space = $this->getToolkit()->golapiLivingSpaceAdapter->parse($data,$width,$height);
        return $this->responseOk($this->toRest($space));
    }

    public function samplesAction()
    {
        $datadir = dirname(dirname(dirname(dirname(__DIR__)))).'/data';
        $files = array_diff(scandir($datadir),['.','..']);
        return $this->responseOk($this->toRest($files));
    }


}