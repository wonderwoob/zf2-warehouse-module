<?php
namespace Warehouse;

use Warehouse\Model\Warehouse;
use Warehouse\Model\WarehouseTable;
use Warehouse\Model\Product;
use Warehouse\Model\ProductTable;
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

    // Add this method:
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Warehouse\Model\WarehouseTable' =>  function($sm) {
                    $tableGateway = $sm->get('WarehouseTableGateway');
                    $table = new WarehouseTable($tableGateway);
                    return $table;
                },
                'WarehouseTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Warehouse());
                    return new TableGateway('Warehouse', $dbAdapter, null, $resultSetPrototype);
                },
                'Warehouse\Model\ProductTable' =>  function($sm) {
                    $tableGateway = $sm->get('ProductTableGateway');
                    $table = new ProductTable($tableGateway);
                    return $table;
                },
                'ProductTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Product());
                    return new TableGateway('Product', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}
