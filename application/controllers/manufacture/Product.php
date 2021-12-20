<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {
	public $mLayout = 'porto/';

	function __construct() {
		parent:: __construct();

		$this->load->model(['Ims_product_attr_model']);
	}

	function index() {
		$this->mHeader['title'] = 'Product Management';
		$this->mHeader['menu_id'] = 'master_data';

		$search = $this->input->get('search');
		$search = !$search ? '' : $search;

		$filter['A.consultant_id'] = $this->mUser->consultant_id;
		$filter['A.name LIKE'] = "%{$search}%";

		$count = $this->Ims_product_model->count($filter);
		$products = $this->Ims_product_model->find($filter);
		$i = 0;

		$this->mContent['search'] = $search;
		$this->mContent['count'] = $count;
		$this->mContent['products'] = [];
		foreach ($products as $product) :
			$attrs = $this->Ims_product_attr_model->find(['product_id' => $product->id]);
			$product->variants = 1;
			foreach ($attrs as $attr) :
				$product->variants *= count(explode(',', $attr->value));
			endforeach;

			$product->quantity = 0;
			$this->mContent['products'][intval($i / 4)][] = $product;
			$i ++;
		endforeach;

		$this->render('manufacture/product/list', $this->mLayout);
	}

	function create($id = -1) {
		$param = $this->input->post('create');

		if (!$param) {
			$this->mHeader['title'] = 'Create Product';
			$this->mHeader['menu_id'] = 'master_data';

			$this->mContent['categories'] = $this->Ims_category_model->find(['A.employee_id' => $this->mUser->employee_id]);

			$product = $this->Ims_product_model->one(['A.id' => $id]);
			if ($product)
				$product->attrs = $this->Ims_product_attr_model->find(['product_id' => $id], ['id' => 'asc']);

			$this->mContent['product'] = $product;

			$this->render('manufacture/product/create', $this->mLayout);
		} else {
			$upload = $_FILES['userfile'];
			if (!empty($upload['name'])) {
				$file_name = substr(sha1(rand(1, 10000)), 0, 20);
				$config['upload_path'] = "./uploads/product/";
				$config['file_name'] = $file_name;
				$config['allowed_types'] = 'jpg|png|bmp|ico';
				$config['max_size'] = '2048000';
				$config['max_width'] = '10000';
				$config['max_height'] = '10000';

				$this->upload->initialize($config);

				if ($this->upload->do_upload()) {
					$data = $this->upload->data();
					$param['image'] = $file_name . $data['file_ext'];
				}
			}

			if (!isset($param['is_sold']))
				$param['is_sold'] = 0;
			else if ($param['is_sold'] == 'on')
				$param['is_sold'] = 1;

			if (!isset($param['is_purchased']))
				$param['is_purchased'] = 0;
			else if ($param['is_purchased'] == 'on')
				$param['is_purchased'] = 1;

			if ($id == -1) {
				$param['consultant_id'] = $this->mUser->consultant_id;
				$param['employee_id'] = $this->mUser->employee_id;
				$param['create_at'] = date('Y-m-d H:i:s');
				$inserted_id = $this->Ims_product_model->insert($param);

				$attrs = $this->input->post('attr');
				foreach ($attrs as $item) :
					$item['product_id'] = $inserted_id;
					$this->Ims_product_attr_model->insert($item);
				endforeach;

				$msg = 'Successfully created.';
			} else {
				$this->Ims_product_attr_model->delete(['product_id' => $id]);

				$param['update_at'] = date('Y-m-d H:i:s');
				$this->Ims_product_model->update(['id' => $id], $param);

				$attrs = $this->input->post('attr');
				foreach ($attrs as $item) :
					$item['product_id'] = $id;
					$this->Ims_product_attr_model->insert($item);
				endforeach;

				$msg = 'Successfully updated.';
			}

			$this->session->set_flashdata('flash', [
				'success' => true,
				'msg' => $msg
			]);

			$this->redirect('manufacture/product');
		}
	}

	function upload() {
	}
}