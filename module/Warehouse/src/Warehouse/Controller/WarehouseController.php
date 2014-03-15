<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 13/03/14
 * Time: 18:29
 */
namespace Warehouse\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Warehouse\Model\Warehouse;
use Warehouse\Form\WarehouseForm;

class WarehouseController extends AbstractActionController
{
    protected $warehouseTable;

    public function getWarehouseTable()
    {
        if (!$this->warehouseTable) {
            $sm = $this->getServiceLocator();
            $this->warehouseTable = $sm->get('Warehouse\Model\WarehouseTable');
        }
        return $this->warehouseTable;
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'warehouses' => $this->getWarehouseTable()->fetchAll(),
        ));
    }

    public function addAction()
    {
        $form = new WarehouseForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $warehouse = new Warehouse();
            $form->setInputFilter($warehouse->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $warehouse->exchangeArray($form->getData());
                $this->getWarehouseTable()->saveWarehouse($warehouse);

                // Redirect to list of albums
                return $this->redirect()->toRoute('warehouse');
            }
        }
        return array('form' => $form);

    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('warehouse', array(
                'action' => 'add'
            ));
        }

        // Get the Album with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $album = $this->getWarehouseTable()->getWarehouse($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('warehouse', array(
                'action' => 'index'
            ));
        }

        $form  = new WarehouseForm();
        $form->bind($album);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getWarehouseTable()->saveWarehouse($album);

                // Redirect to list of albums
                return $this->redirect()->toRoute('warehouse');
            }
        }
        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        //$this->layout('album/delete');
    }
}