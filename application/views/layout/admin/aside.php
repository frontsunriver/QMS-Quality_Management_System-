<div class="sidebar sidebar-main sidebar-fixed">
	<div class="sidebar-content">
		<div class="sidebar-category sidebar-category-visible">
			<div class="category-content no-padding">
				<ul class="navigation navigation-main navigation-accordion">

					<!-- Main -->
					<li class="navigation-header">
						<span>Main</span> <i class="icon-menu" title="Main pages"></i>
					</li>
					<li>
						<a href="<?= base_url('admin/membership') ?>"><i class="icon-home4"></i> 
							<span>Dashboard</span></a>
					</li>
					<li>
						<a href="<?= base_url('admin/consultant_list') ?>" class="<?= $menu_title == 'Owner Management' ? 'active' : 'clist' ?>"><i class="icon-stack2"></i> 
							<span>Owner Management</span></a>
					</li>
					<li>
						<a href="<?= base_url('admin/plan_list') ?>" class="<?= $menu_title == 'Plans' ? 'active' : 'clist' ?>"><i class="icon-lan2"></i> 
							<span>Subscription Management</span></a>
					</li>
					<li>
						<a href="<?= base_url('admin/invoice/list') ?>" class="<?= $menu_title == 'Invoice Management' ? 'active' : 'paylist' ?>"><i class="icon-coin-dollar" ></i> 
							<span>Invoice Management</span></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>