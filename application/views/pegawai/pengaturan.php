<?php $active = html_escape($this->input->get('type'));?>
<div class="row">
	<div class="col-md-3">
		<div class="panel mailbox">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fas fa-coins"></i> Master Data</h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
					<li class="<?php if ($inside_subview == 'lokasi') echo 'active'; ?>">
						<a href="<?=base_url('pegawai/pengaturan/lokasi')?>">
                            <i class="fas fa-map-marker-alt"></i> Lokasi
						</a>
					</li>
					<li class="<?php if ($inside_subview == 'jabatan') echo 'active'; ?>">
						<a href="<?=base_url('pegawai/pengaturan/jabatan')?>"> <i class="fas fa-address-card"></i> Jabatan
						</a>
					</li>
					<li class="<?php if ($inside_subview == 'shift') echo 'active'; ?>">
						<a href="<?=base_url('pegawai/pengaturan/shift')?>"><i class="fas fa-retweet"></i> Shift Pegawai
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<?php $this->load->view('pegawai/'. $inside_subview . '.php') ?>
	</div>
</div>