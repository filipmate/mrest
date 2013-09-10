<?php

namespace MRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;

use Zend\View\Model\JsonModel;
use Zend\Http\Request as HttpRequest;
use Zend\Stdlib\RequestInterface as Request;
use Zend\Stdlib\ResponseInterface as Response;

class RestController extends AbstractRestfulController
{
    protected $mapper;

    public function dispatch(Request $request, Response $response = null)
    {
        //for not rest support clients, use method name in header header X-HTTP-Method-Override
        if ( $request instanceof HttpRequest)
        {
            $method = $request->getHeader('X-HTTP-Method-Override', false);
            if ( $method )
            {
                $request->setMethod(str_replace('X-Http-Method-Override: ', '', $method->toString()));
            }
        }

        parent::dispatch($request, $response);
    }

    public function getList()
    {
        return new JsonModel($this->getMapper()->fetchAll());
    }

    public function get($id)
    {
        $row = $this->getMapper()->get($id);
        //@todo message if row not find
        return new JsonModel($row->toArray());
    }

    public function create($data)
    {
        $row = $this->getMapper()->getEntityPrototype();
        $row->exchangeArray($data);
        //@todo filter/validate data
        $this->getMapper()->save($row);
        return new JsonModel($row->toArray());
    }

    public function update($id, $data)
    {
        $row = $this->getMapper()->getEntityPrototype();
        $row->exchangeArray($data);
        $row->id = $id;
        //@todo filter/validate data
        $this->getMapper()->save($row);
        return new JsonModel($row->toArray());
    }

    public function delete($id)
    {
        return new JsonModel($this->getMapper()->delete($id));
    }

    /**
     * @return \MRest\Model\MapperInterface
     */
    protected function getMapper()
    {
        if (!$this->mapper)
        {
            $sm = $this->getServiceLocator();
            $entityType = $this->getEvent()->getRouteMatch()->getParam('entity');
            $this->mapper = $sm->get($entityType);
        }
        if (!($this->mapper instanceof \MRest\Model\MapperInterface))
        {
            throw new \Exception("Mapper don't implements \\MRest\\Model\\MapperInterface");
        }
        return $this->mapper;
    }
}
