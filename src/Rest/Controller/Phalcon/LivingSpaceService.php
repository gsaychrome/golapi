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
        $this->map['post']["/{$this->getUrlBase()}/load"] = "load";
        $this->map['post']["/{$this->getUrlBase()}/save"] = "save";
        $this->map['get']["/{$this->getUrlBase()}/samples"] = "samples";
        $this->map['get']["/{$this->getUrlBase()}/saved"] = "saved";
        $this->map['get']["/{$this->getUrlBase()}/get/{id}"] = "get";
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
        try {
            $request = $this->getJsonRawBody(true);
            $name = $request['name'];
            $width = (int)$request['width'];
            $height = (int)$request['height'];
            $data = file_get_contents(dirname(dirname(dirname(dirname(__DIR__)))) . '/data/' . $name);
            $space = $this->getToolkit()->golapiLivingSpaceAdapter->createSpace($width, $height);
            $space = $this->getToolkit()->golapiLivingSpaceAdapter->parse($data, $space);
            return $this->responseOk($this->toRest($space));
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function samplesAction()
    {
        try {
            $datadir = dirname(dirname(dirname(dirname(__DIR__)))) . '/data';
            $files = array_diff(scandir($datadir), ['.', '..']);
            return $this->responseOk($this->toRest($files));
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function savedAction()
    {
        try {
            $spaces = $this->getToolkit()->golapiLivingSpaceAdapter->createFilter()->getResults(['id', 'name', 'savedOn']);
            return $this->responseOk($this->toRest($spaces, ['system' => true]));
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function getAction($id)
    {
        try {
            $space = $this->getToolkit()->golapiLivingSpaceAdapter->get($id);
            return $this->responseOk($this->toRest($space));
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function saveAction()
    {
        try {
            // TODO: hibakezelés
            $request = $this->getJsonRawBody(true);
            $space = $this->getToolkit()->golapiLivingSpaceAdapter->fetch($request);
            $id = $this->getToolkit()->golapiLivingSpaceAdapter->save($space);
            $space = $this->getToolkit()->golapiLivingSpaceAdapter->get($id);
            return $this->responseOk($this->toRest($space));
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

}