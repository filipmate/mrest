<?php
namespace MRest\Model;

use Zend\Db\TableGateway\TableGateway;

class Mapper implements MapperInterface
{
    /**
     * @var \Zend\Db\TableGateway\TableGateway
     */
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getEntityPrototype()
    {
        return $this->tableGateway->getResultSetPrototype()->getArrayObjectPrototype();
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function get($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row");
        }
        return $row;
    }

    public function save(Entity $entity)
    {
        $data = $entity->getArrayCopy();

        $id = (int) $entity->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->get($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function delete($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}