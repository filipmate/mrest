<?php
namespace MRest\Model;

interface EntityInterface
{
    public function exchangeArray(array $data);
    public function setValues(array $values);
    public function toArray();
    public function getArrayCopy();
}
