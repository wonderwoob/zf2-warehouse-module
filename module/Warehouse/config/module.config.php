<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Warehouse\Controller\Warehouse' => 'Warehouse\Controller\WarehouseController',
            'Warehouse\Controller\Project' => 'Warehouse\Controller\ProductController',
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'warehouse' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/warehouse[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Warehouse\Controller\Warehouse',
                        'action'     => 'index',
                    ),
                ),
            ),
            'product' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/product[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Warehouse\Controller\Project',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'warehouse' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'warehouse/index'           => __DIR__ . '/../view/warehouse/index.phtml',
            'warehouse/add'           => __DIR__ . '/../view/warehouse/add.phtml',
            'warehouse/edit'           => __DIR__ . '/../view/warehouse/edit.phtml',
            'warehouse/delete'           => __DIR__ . '/../view/warehouse/delete.phtml'
        ),
    ),
);