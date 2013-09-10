<?php
namespace MRest;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;


class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        $factories = array('factories' => array());

        $config = $this->getConfig();
        if (isset($config['mrest']) && isset($config['mrest']['entities']) && is_array($config['mrest']['entities']))
        {
            foreach ($config['mrest']['entities'] as $entityName => $entityConfig)
            {
                $factories['factories'][$entityName . '_table'] = function ($sm) use ($entityConfig)
                {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new $entityConfig['entity']);
                    return new TableGateway($entityConfig['table'], $dbAdapter, null, $resultSetPrototype);
                };
                $factories['factories'][$entityName] = function($sm) use ($entityConfig, $entityName)
                {
                    return new \MRest\Model\Mapper(
                        $sm->get($entityName . '_table')
                    );
                };
            }
        }
        return $factories;
    }
}
