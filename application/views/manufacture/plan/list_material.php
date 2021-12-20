<style>
	#tab2 th {
		font-weight: 700;
		font-size: 15px;
	}
	#tab2 table td > a {
		display: table-caption;
		margin-bottom: 3px;
	}
	.material {
		text-align: -webkit-center;
		font-size: 14px;
	}
</style>

<div class="content col-md-9" style="margin-left: auto; margin-right: auto;">
	<div class="panel panel-flat">
		<div class="panel-heading">
			<h5 class="panel-title" style="display: inline-block;">Material Planing Management</h5>
			<button type="button" class="btn bg-blue pull-right" onclick="javascript:onAdd(-1);">ADD</button>
		</div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<div class="tabbable">
						<ul class="nav nav-tabs nav-tabs-top top-divided">
							<li class="<?= $view == 'frequency' ? 'active' : '' ?>">
								<a href="<?= base_url('manufacture/plan?type=material&view=frequency') ?>">By Frequency</a>
							</li>
							<li class="<?= $view == 'calendar' ? 'active' : '' ?>">
								<a href="<?= base_url('manufacture/plan?type=material&view=calendar') ?>">By Calendar</a>
							</li>
						</ul>
						<div class="tab-content">
							<div id="tab1" class="tab-pane <?= $view == 'frequency' ? 'active' : '' ?>">
								<table class="table datatable-material"></table>
							</div>
							<div id="tab2" class="tab-pane <?= $view == 'calendar' ? 'active' : '' ?>">
								<table class="table table-responsive-md  mb-0 table-bordered">
									<tr>
										<th rowspan="2" width="20%" class="center">Material</th>
										<th rowspan="2" width="5%" class="center">Duration</th>
										<th colspan="12" width="75%" class="center">Plan</th>
									</tr>
									<tr>
										<?php
											$current_month = intval(date("m"));
											for ($i = 0; $i < 8; $i ++) {
												switch ($current_month) {
												case 1:
													echo '<th class="center">Jan</th>';
													break;
												case 2:
													echo '<th class="center">Feb</th>';
													break;
												case 3:
													echo '<th class="center">March</th>';
													break;
												case 4:
													echo '<th class="center">April</th>';
													break;
												case 5:
													echo '<th class="center">May</th>';
													break;
												case 6:
													echo '<th class="center">June</th>';
													break;
												case 7:
													echo '<th class="center">July</th>';
													break;
												case 8:
													echo '<th class="center">Aug</th>';
													break;
												case 9:
													echo '<th class="center">Sept</th>';
													break;
												case 10:
													echo '<th class="center">Oct</th>';
													break;
												case 11:
													echo '<th class="center">Nov</th>';
													break;
												case 12:
													echo '<th class="center">Dec</th>';
													break;
												}
												$current_month ++;
												if ($current_month > 12)
													$current_month = $current_month - 12;
											}
										?>
									</tr>
									<?php foreach ($materials as $material) : ?>
										<tr>
											<td class="material">
												<a href="#"><?= $material->name ?></a></td>
											<td class="center">0</td>
											<?php for ($i = 0; $i < 8; $i ++) { ?>
												<td>
													<?php
													$cur = new DateTime(date('Y-m-d'));
													$cur->add(new DateInterval("P{$i}M"));
													$key = $cur->format('Y-m');
													if (isset($plans[$key])) :
														foreach ($plans[$key] as $plan) :
															if ($material->id == $plan->material_id) :
													?>
															<a class="btn btn-xs btn-primary " href="#" style="font-size: 8px; color: white" onclick="javascript:onMakePurchaseOrder(<?= $plan->id ?>);">
																<?= $plan->order_date ?></a>
															<?php endif; ?>
														<?php endforeach; ?>
													<?php endif; ?>
												</td>
											<?php } ?>
										</tr>
									<?php endforeach; ?>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="modal_save" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url(PLUGINS_URL . 'pickers/anytime.min.js') ?>"></script>

<script type="text/javascript" src="<?= base_url(JS_URL . 'user/manufacture/plan/list_material.js') ?>"></script>