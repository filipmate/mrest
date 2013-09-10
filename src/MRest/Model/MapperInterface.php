<?php
namespace MRest\Model;

interface MapperInterface
{
    /**
     * @return \MRest\Model\EntityInterface
     */
    public function getEntityPrototype();
    public function fetchAll();
    public function get($id);
    public function save(Entity $entity);
    public function delete($id);
}
