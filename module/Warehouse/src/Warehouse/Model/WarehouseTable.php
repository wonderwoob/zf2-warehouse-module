<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 14/03/14
 * Time: 17:18
 */
namespace Warehouse\Model;

use Zend\Db\TableGateway\TableGateway;

class WarehouseTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getWarehouse($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveWarehouse(Warehouse $album)
    {
        $data = array(
            'name' => $album->name,
            'description'  => $album->description,
        );

        $id = (int) $album->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getWarehouse($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Warehouse id does not exist');
            }
        }
    }

    public function deleteWarehouse($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }
}