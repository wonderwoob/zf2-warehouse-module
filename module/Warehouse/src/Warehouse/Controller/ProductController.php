<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 13/03/14
 * Time: 18:29
 */
namespace Warehouse\Controller;

use Warehouse\Model\Product;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Warehouse\Model\Warehouse;
use Warehouse\Form\ProductForm;

class ProductController extends AbstractActionController
{
    protected $productTable;

    public function getProductTable()
    {
        if (!$this->productTable) {
            $sm = $this->getServiceLocator();
            $this->productTable = $sm->get('Warehouse\Model\ProductTable');
        }
        return $this->productTable;
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'products' => $this->getProductTable()->fetchAll(),
        ));
    }

    public function addAction()
    {
        $form = new ProductForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $warehouse = new Product();
            $form->setInputFilter($warehouse->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $warehouse->exchangeArray($form->getData());
                $this->getProductTable()->saveProduct($warehouse);

                // Redirect to list of albums
                return $this->redirect()->toRoute('product');
            }
        }
        return array('form' => $form);

    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('product', array(
                'action' => 'add'
            ));
        }

        // Get the Album with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $album = $this->getProductTable()->getProduct($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('product', array(
                'action' => 'index'
            ));
        }

        $form  = new ProductForm();
        $form->bind($album);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getProductTable()->saveProduct($album);

                // Redirect to list of albums
                return $this->redirect()->toRoute('product');
            }
        }
        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('product');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getProductTable()->deleteProduct($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('product');
        }

        return array(
            'id'    => $id,
            'product' => $this->getProductTable()->getProduct($id)
        );
    }
}