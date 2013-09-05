<?php
namespace MRest\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Filter\Word\CamelCaseToUnderscore;
use Zend\Filter\Word\UnderscoreToCamelCase;

class Entity
{
    public function exchangeArray($data)
    {
        $filter = new CamelCaseToUnderscore();
        $objectVariablesArray = get_object_vars($this);
        foreach( $objectVariablesArray as $key => $value )
        {
            $arrayKey = strtolower($filter->filter($key));
            $currentData = isset($data[$arrayKey]) ? $data[$arrayKey] : (isset($data[$key]) ? $data[$key] : null);
            if ( is_array($currentData) )
            {
                $relationType = $this->getClassByRelation($key);
                if ( $relationType instanceof OneToMany )
                {
                    $this->$key = array();
                    foreach ( $currentData as $value )
                    {
                        $relatedObject = new $relationType->className;
                        $relatedObject->exchangeArray($value);
                        array_push($this->$key, $relatedObject);
                    }
                }
            }
            else
            {
                $this->$key = $currentData;
            }
        }
    }

    public function setValues(array $values)
    {
        foreach ( $values as $key => $value )
        {
            // @todo validate if $key exists
            $this->$key = $value;
        }
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        throw new \Exception("Not used");
    }

    public function toArray()
    {
        $arr = array();
        $objectVariablesArray = get_object_vars($this);
        foreach ($objectVariablesArray as $key => $value )
        {
            $arr[$key] = $this->$key;
        }
        return $arr;
    }

    public function getArrayCopy()
    {
        $objectVariablesArray = get_object_vars($this);
        $formattedArray = array();
        $filter = new CamelCaseToUnderscore();
        foreach ( $objectVariablesArray as $key => $value )
        {
            if (!empty($value) && !is_array($value))
            {
                $formattedArray[strtolower($filter->filter($key))] = $value;
            }
        }
        return $formattedArray;
    }
}