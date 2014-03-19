<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 18/03/14
 * Time: 16:45
 */
return array(
    array(
        'label' => 'Home',
        'route' => 'home',
    ),
    array(
        'label' => 'Warehouse',
        'route' => 'warehouse',
        'pages' => array(
            array(
                'label' => 'Add',
                'route' => 'warehouse',
                'action' => 'add',
            ),
            array(
                'label' => 'List',
                'route' => 'warehouse',
                'action' => 'index',
            )
        ),
    ),
    array(
        'label' => 'Product',
        'route' => 'product',
        'class' => 'dropdown-toggle',
        'pages' => array(
            array(
                'label' => 'Add',
                'route' => 'product',
                'action' => 'add',
            ),
            array(
                'label' => 'List',
                'route' => 'product',
                'action' => 'index',
            )
        ),
    ),
);