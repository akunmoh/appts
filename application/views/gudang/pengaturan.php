<?php $active = html_escape($this->input->get('type'));?>
<div class="row">
	<div class="col-md-3">
		<div class="panel mailbox">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fas fa-coins"></i> Master Data</h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
					<li class="<?php if ($inside_subview == 'kategori') echo 'active'; ?>">
						<a href="<?=base_url('gudang/pengaturan/kategori')?>">
                            <i class="fas fa-list-ul"></i> Kategori Barang
						</a>
					</li>
					<li class="<?php if ($inside_subview == 'unit') echo 'active'; ?>">
						<a href="<?=base_url('gudang/pengaturan/unit')?>"> <i class="fas fa-cube"></i> Unit Barang
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<?php $this->load->view('gudang/'. $inside_subview . '.php') ?>
	</div>
</div>