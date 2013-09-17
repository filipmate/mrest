MRest
=====

Introduction
------------
This is a simple, yet powerful Zend Framerok 2 module, which allows REST access to database table only by add this table into config file.

Installation
------------

 * Install [ZendSkeletonApplication](https://github.com/zendframework/ZendSkeletonApplication)
 * [Configure service_manager for Zend\Db\Adapter\Adapter](http://framework.zend.com/manual/2.0/en/user-guide/database-and-models.html)
 * Colne this modelu into path/to/application/modules/MRest directory
 * Enable module in file path/to/application/config/application.config.php, by adding MRest in modules array

Example
-------

To make example work you need to import path/to/application/modules/MRest/data/data.sql to your database.
Now you are able to:
 * fetch list of database record - GET http://applicationpath/rest/example
 * fetch single record - GET http://applicationpath/rest/example/2
 * create record - PUT http://applicationpath/rest/example
 * update record - POST http://applicationpath/rest/example/2
 * delete record - DELETE http://applicationpath/rest/example/2


To add REST access to another table, you need to create its Entity and add it in your module.config.php:
```sh
    'mrest' => array(
        'entities' => array(
            'example' => array(
                'table' => 'table_name', // table in database, '\Module\Model\Entity'
                'entity' => '\Module\Model\Entity', // entity, which extends \MRest\Model\Entity
            ),
        ),
    ),
```
