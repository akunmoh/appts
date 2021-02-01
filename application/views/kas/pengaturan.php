<?php $active = html_escape($this->input->get('type'));?>
<div class="row">
	<div class="col-md-3">
		<div class="panel mailbox">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fas fa-coins"></i> Master Data</h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
					<li class="<?php if ($inside_subview == 'sumber_pemasukkan') echo 'active'; ?>">
						<a href="<?=base_url('kas/pengaturan/pemasukkan')?>">
                            <i class="fas fa-list-ul"></i> Sumber Pemasukkan
						</a>
					</li>
					<li class="<?php if ($inside_subview == 'sumber_pengeluaran') echo 'active'; ?>">
						<a href="<?=base_url('kas/pengaturan/pengeluaran')?>"> <i class="fas fa-cube"></i> Sumber Pengeluaran
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<?php $this->load->view('kas/'. $inside_subview . '.php') ?>
	</div>
</div>