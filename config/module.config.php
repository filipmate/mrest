<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'MRest\Controller\Rest' => 'MRest\Controller\RestController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'video' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'router' => array(
        'routes' => array(
            'video-rest' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/rest[/:entity][/:id]',
                    'constraints' => array(
                        'entity' => '[a-zA-Z0-9_-]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'MRest\Controller\Rest',
                    ),
                ),
            ),
        ),
    ),
    'mrest' => array(
        'entities' => array(
            'example' => array(
                'table' => 'example',
                'entity' => '\MRest\Model\Example',
            ),
        ),
    ),
);