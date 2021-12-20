<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Timon
 * Date: 12/11/2018
 * Time: 3:47 PM
 */

class Order extends MY_Controller
{

    public $mLayout = 'porto/';

    function index() {
        $this->mHeader['title'] = 'Sales Orders';
        $this->mHeader['menu_id'] = 'sales_order';

        $this->render('sales/order/list', $this->mLayout);
    }

    function create($id = -1) {
        $param = $this->input->post('sale_order');

        if (!$param) {
            $this->mHeader['title'] = 'Sales Orders';
            $this->mHeader['menu_id'] = 'sales_order';

            $this->mContent['customers'] = $this->Ims_customer_model->find(['consultant_id' => $this->mUser->consultant_id]);
            $this->mContent['warehouses'] = $this->Ims_warehouse_model->find(['consultant_id' => $this->mUser->consultant_id]);
            $this->mContent['employees'] = $this->Employees_model->find(['consultant_id' => $this->mUser->consultant_id]);
            $this->mContent['products'] = $this->Ims_product_model->find(['consultant_id' => $this->mUser->consultant_id]);
            
            $this->mContent['saleorder'] = null;
        
            $this->render('sales/order/create', $this->mLayout);
        }
    }

    function viewData($id = 0)
    {
        if($id == 0){
            $this->mHeader['title'] = 'New Sales Order';
            $this->mHeader['menu_id'] = 'sales_order';
            $this->mContent['id'] = 0;
        }else{
            $this->mHeader['title'] = 'Edit Sales Order';
            $this->mHeader['menu_id'] = 'sales_order';
            $this->mContent['id'] = $id;
        }

        $this->render('sales/order/view', $this->mLayout);
    }

    function delivery(){
        $this->mHeader['title'] = 'Delivery Manage';
        $this->mHeader['menu_id'] = 'sales_order';
        $this->render('sales/order/delivery_list', $this->mLayout);
    }

    function create_delivery(){
        $this->mHeader['title'] = 'Delivery Create';
        $this->mHeader['menu_id'] = 'sales_order';
        $this->render('sales/order/delivery_create', $this->mLayout);
    }
}