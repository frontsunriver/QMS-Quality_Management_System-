<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Timon
 * Date: 12/10/2018
 * Time: 2:26 PM
 */

class Ship extends MY_Controller
{
    public $mLayout = 'porto/';

    function index() {
        $this->mHeader['title'] = 'Ship Order';
        $this->mHeader['menu_id'] = 'ship';
        $this->render('warehouse/ship/list', $this->mLayout);
    }

    function get($id) {
        $product = $this->Ims_product_model->one(
            ["A.id" => $id],
            ["A.*"]
        );

        $this->json($product);
    }

    function confirm($id) {
        $this->Ims_ship_order_model->update(['id' => $id], ['state' => 1]);
        $this->session->set_flashdata('flash', [
            'success' => true,
            'msg' => 'Successfully confirmed.'
        ]);
        $this->redirect('warehouse/ship');
    }

    function read() {

        $table_data['ship_order'] = $this->Ims_ship_order_model->getAllShipOrderByWHID($this->mUser->employee_id);
        $table_data['iTotalRecords'] = count($table_data['ship_order']);
        $table_data['iTotalDisplayRecords'] = count($table_data['ship_order']);

        foreach ($table_data['ship_order'] as $key => $row) {
            $table_data['ship_order'][$key]["no"] = $key + 1;
        }
        $this->json($table_data);
    }

    function create($id = -1) {
        $order = $this->input->post('order');

        if (!$order) {
            $this->mHeader['title'] = 'New Ship Order';
            $this->mHeader['menu_id'] = 'ship';

            $this->mContent['partners'] = $this->Ims_customer_model->find();

            $this->mContent['order'] = $this->Ims_ship_order_model->one(['A.id' => $id]);

            $this->db->join("ims_ship_order B", "A.ship_order_id = B.id", 'left');
            $this->mContent['ship_products'] = $this->Ims_ship_order_product_model->find([
                "B.id" => $id
            ], [], [
                "A.*"
            ]);

            $this->render('warehouse/ship/create', $this->mLayout);
        } else {
            $products = $this->input->post('products');

            if ($id == -1) {
                $order['warehouse_id'] = $this->mUser->employee_id;
                $order['scheduled_date'] = date("Y-m-d H:i:s");
                $order_id = $this->Ims_ship_order_model->insert($order);

                foreach($products as $product) {
                    $product['ship_order_id'] = $id;
                    $this->Ims_ship_order_product_model->insert($product);
                }
            } else {
                $this->Ims_ship_order_model->update(['id' => $id], $order);
                $this->Ims_ship_order_product_model->delete(['ship_order_id' => $id]);

                foreach($products as $product) {
                    $product['ship_order_id'] = $id;
                    $this->Ims_ship_order_product_model->insert($product);
                }
            }

            $this->redirect('warehouse/ship');
        }
    }

    function delete($id) {
        $this->Ims_ship_order_model->delete(['id' => $id]);
        $this->Ims_ship_order_product_model->delete(['ship_order_id' => $id]);

        $this->success();
    }

}