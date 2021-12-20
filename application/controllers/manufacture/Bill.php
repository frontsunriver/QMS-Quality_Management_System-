<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bill extends MY_Controller {
	public $mLayout = 'porto/';

	function __construct() {
		parent::__construct();

		$this->load->model(['Ims_product_attr_model']);
	}

	function index() {
		$this->mHeader['title'] = 'Bill of Material';
		$this->mHeader['menu_id'] = 'master_data';
		$this->render('manufacture/bill/list', $this->mLayout);
	}

	function read() {
		$param = $this->input->post();

		$data = [];

		$filter = [
			'A.consultant_id' => $this->mUser->consultant_id,
		];

		$data['iTotalRecords'] = $this->Ims_bill_model->count($filter);

		$filter['B.name LIKE'] = "%{$param['sSearch']}%";

		$this->db->join("{$this->Ims_product_model->_table} B", 'A.product_id = B.id', 'LEFT');
		$data['iTotalDisplayRecords'] = $this->Ims_bill_model->count($filter);

		$orders = [];
		for ($i = 0; $i < $param['iSortingCols']; $i ++) {
			$sortCol = $param["iSortCol_{$i}"];
			if ($param["mDataProp_{$sortCol}"] == 'product_name')
				$orders['B.name'] = $param["sSortDir_{$i}"];
			else
				$orders['A.' . $param["mDataProp_{$sortCol}"]] = $param["sSortDir_{$i}"];
		}

		foreach ($orders as $key => $val)
			$this->db->order_by($key, $val);

		$this->db->limit($param['iDisplayLength'], $param['iDisplayStart']);

		$this->db->join("{$this->Ims_product_model->_table} B", 'A.product_id = B.id', 'LEFT');
		$data['bill'] = $this->Ims_bill_model->find($filter, [], [
			'A.*', 'B.name product_name'
		]);
		$data['sEcho'] = $param['sSearch'];

		$this->json($data);
	}

	function create($id = -1) {
		$param = $this->input->post('bill');

		if (!$param) {
			$this->mHeader['title'] = $id == -1 ? 'Create Bill of Material' : 'Update Bill of Material';
			$this->mHeader['menu_id'] = 'master_data';

			$products = $this->Ims_product_model->find(['consultant_id' => $this->mUser->consultant_id]);
			foreach ($products as $item) :
				$attrs = $this->Ims_product_attr_model->find(['product_id' => $item->id], ['id' => 'asc']);
				if (!empty($attrs)) :
					$variants = [];
					foreach ($attrs as $attr) :
						$variants[] = explode(',', $attr->value);
					endforeach;

					$this->mVariants = [];
					for ($i = 0; $i < count($variants[0]); $i ++)
						$this->getVariants($variants, 0, $i, '');

					$item->variants = $this->mVariants;
				endif;
			endforeach;

			$this->mContent['products'] = $products;

			$this->mContent['materials'] = $this->Ims_material_model->find(['consultant_id' => $this->mUser->consultant_id]);

			$material_id = empty($this->mContent['materials']) ? -1 : $this->mContent['materials'][0]->id;
			$this->mContent['quantity'] = $this->Ims_warehouse_material_model->select_sum(['material_id' => $material_id], 'quantity');

			$this->mContent['bill'] = $this->Ims_bill_model->one(['id' => $id]);
			$materials = $this->Ims_bill_material_model->find(['bill_id' => $id]);
			foreach ($materials as $material) :
				$material->quantity = $this->Ims_warehouse_material_model->select_sum(['material_id' => $material->material_id], 'quantity');
			endforeach;
			
			$this->mContent['bill_materials'] = $materials;

			$this->render('manufacture/bill/create', $this->mLayout);
		} else {
			$manufacture = $this->input->post('manufacture');
			$kit = $this->input->post('kit');

			if (isset($manufacture) && $manufacture == 'on')
				$param['bom_type'] = 0;
			else if (isset($kit) && $kit == 'on')
				$param['bom_type'] = 1;

			$materials = $this->input->post('material');

			$arr = explode('@', $param['product_id']);
			$param['product_id'] = $arr[0];
			$param['variant'] = isset($arr[1]) ? $arr[1] : null;

			if ($id == -1) {
				$param['create_at'] = date('Y-m-d H:i:s');
				$param['consultant_id'] = $this->mUser->consultant_id;
				$param['employee_id'] = $this->mUser->employee_id;
				$inserted_id = $this->Ims_bill_model->insert($param);

				foreach($materials as $material) :
					$material['bill_id'] = $inserted_id;
					$this->Ims_bill_material_model->insert($material);
				endforeach;

				$msg = 'Successfully created.';
			} else {
				$this->Ims_bill_material_model->delete(['bill_id' => $id]);

				$param['update_at'] = date('Y-m-d H:i:s');
				$this->Ims_bill_model->update(['id' => $id], $param);

				foreach($materials as $material) :
					$material['bill_id'] = $id;
					$this->Ims_bill_material_model->insert($material);
				endforeach;

				$msg = 'Successfully updated.';
			}

			$this->session->set_flashdata('flash', [
				'success' => true,
				'msg' => $msg
			]);

			$this->redirect('manufacture/bill');
		}
	}

	function get_material_quantity($id) {
		$quantity = $this->Ims_warehouse_material_model->select_sum(['material_id' => $id], 'quantity');
		$this->json($quantity);
	}

	function delete($id) {
		$this->Ims_bill_model->delete(['id' => $id]);
		$this->Ims_bill_material_model->delete(['bill_id' => $id]);

		$this->session->set_flashdata('flash', [
			'success' => true,
			'msg' => 'Successfully removed.'
		]);

		$this->success();
	}
}