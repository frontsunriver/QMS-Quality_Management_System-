<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Timon
 * Date: 12/10/2018
 * Time: 2:26 PM
 */

class Product extends MY_Controller {
	public $mLayout = 'porto/';
	public $mVariant;

	function __construct() {
		parent::__construct();

		$this->load->model(['Ims_warehouse_product_model', 'Ims_product_attr_model']);
	}

	function index() {
		$this->mHeader['title'] = 'Product Wise Stock';
		$this->mHeader['menu_id'] = 'product';

		$search = $this->input->get('search');
		if (!$search)
			$seach = '';

		$this->mContent['search'] = $search;

		$results = $this->Ims_product_model->find(['A.consultant_id' => $this->mUser->consultant_id, 'A.name LIKE ' => "%$search%"]);

		$iPos = 0;
		foreach ($results as $item) :
			$attrs = $this->Ims_product_attr_model->find(['product_id' => $item->id], ['id' => 'asc']);
			if (!empty($attrs)) {
				$variants = [];
				foreach ($attrs as $attr) :
					$variants[] = explode(',', $attr->value);
				endforeach;

				$this->mVariants = [];
				for ($i = 0; $i < count($variants[0]); $i ++)
					$this->getVariants($variants, 0, $i, '');

				foreach ($this->mVariants as $variant) :
					$record = $this->Ims_warehouse_product_model->one(['product_id' => $item->id, 'variant' => $variant]);
					$this->mContent['products'][intval($iPos ++ / 4)][] = [
						'image' => $item->image,
						'name' => $item->name,
						'variant' => $variant,
						'sales_price' => $item->sales_price,
						'quantity' => $record ? $record->quantity : 0
					];
				endforeach;
			} else {
				$record = $this->Ims_warehouse_product_model->one(['product_id' => $item->id]);
				$this->mContent['products'][intval($iPos ++ / 4)][] = [
					'image' => $item->image,
					'name' => $item->name,
					'variant' => '',
					'sales_price' => $item->sales_price,
					'quantity' => $record ? $record->quantity : 0
				];
			}
		endforeach;

		$this->render('warehouse/product/list', $this->mLayout);
	}
}