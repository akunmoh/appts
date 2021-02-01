<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"> Filter</h4>
	</header>
	<?php echo form_open($this->uri->uri_string(), array('class' => 'validate')); ?>
	<div class="panel-body">
		<div class="row mb-sm">
			<div class="col-md-4 mb-sm">
				<div class="form-group">
					<label class="control-label">Lokasi</label>
					<?php
						echo form_dropdown("lokasi_id", $lokasilist, set_value('lokasi_id'), "class='form-control' data-plugin-selectTwo
						data-width='100%' data-minimum-results-for-search='Infinity'");
					?>
				</div>
			</div>
			<div class="col-md-4 mb-sm">
				<div class="form-group">
					<label class="control-label">Jabatan</label>
					<?php
					echo form_dropdown("jabatan_id", $jabatanlist, set_value('jabatan_id'), "class='form-control' data-plugin-selectTwo
					data-width='100%' data-minimum-results-for-search='Infinity'");
					?>
				</div>
			</div>
			<div class="col-md-4 mb-sm">
				<div class="form-group">
					<label class="control-label">Shift</label>
					<?php
					echo form_dropdown("shift_id", $shiftlist, set_value('shift_id'), "class='form-control' data-plugin-selectTwo
					data-width='100%' data-minimum-results-for-search='Infinity'");
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="panel-footer">
		<div class="row">
			<div class="col-md-offset-10 col-md-2">
				<button type="submit" name="search" value="1" class="btn btn-default btn-block"><i
						class="fas fa-filter"></i> Filter</button>
			</div>
		</div>
	</div>
	<?php echo form_close(); ?>
</section>

<section class="panel">
	<header class="panel-heading">
		<?php if(get_permission('pegawai', 'is_add')){ ?>
		<div class="panel-btn">
			<a href="javascript:void(0);" class="add_pegawai btn btn-default btn-circle">
				<i class="fas fa-user-plus"></i> Tambah Pegawai
			</a>
		</div>
		<?php } ?>
		<h4 class="panel-title"><i class="fas fa-list-ul"></i> Data Pegawai</h4>
	</header>
	<div class="panel-body">
		<div class="export_title">Laporan Data Pegawai</div>
		<table class="table table-bordered table-hover table-condensed table_default" cellspacing="0" width="100%" id="table-export">
			<thead>
				<tr>
					<th>No.</th>
					<th>Pegawai ID</th>
					<th>Nama Pegawai</th>
					<th>Lokasi</th>
					<th>Jabatan</th>
					<th>Shift</th>
					<th>No Telp</th>
					<th>Alamat</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($pegawailist)){ $count = 1; foreach($pegawailist as $row): ?>
				<tr>
					<td><?php echo $count++; ?></td>
					<td><?php echo html_escape($row['pegawai_id']); ?></td>
					<td><?php echo html_escape($row['nama']); ?></td>
					<td><?php echo html_escape($row['nama_lokasi']); ?></td>
					<td><?php echo html_escape($row['nama_jabatan']); ?></td>
					<td><?php echo html_escape($row['shift']); ?></td>
					<td><?php echo html_escape($row['notelp']); ?></td>
					<td><?php echo html_escape($row['alamat']); ?></td>
					<td>
						<?php if (get_permission('pegawai', 'is_edit')): ?>
						<a href="<?php echo base_url('pegawai/detail/'.$row['id']); ?>" class="btn btn-circle btn-default icon" data-toggle="tooltip" data-original-title="Detail Pegawai"><i class="fas fa-eye"></i>
						</a>
						<?php endif; if (get_permission('pegawai', 'is_delete')): ?>
						<?=btn_delete('pegawai/submitted_data/delete/' . $row['id']); ?>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; }?>
			</tbody>
		</table>
	</div>
</section>

<?php if(get_permission('pegawai', 'is_add')){ ?>
<div id="add_modal" class="zoom-anim-dialog modal-block modal-block-lg mfp-hide">
	<section class="panel">
		<?php
			echo form_open_multipart(base_url('pegawai/submitted_data/create'), array(
			'class' 	=> 'validate',
			'method' 	=> 'post'
			));
		?>
		<div class="panel-heading">
			<h4 class="panel-title">
				<i class="far fa-plus-square"></i> Tambah Pegawai
			</h4>
		</div>

		<div class="panel-body">
			<div class="row">
				<div class="col-md-4 mb-sm">
					<div class="form-group <?php if (form_error('lokasi_id')) echo 'has-error'; ?>">
						<label class="control-label">Lokasi Kerja <span class="required">*</span></label>
						<?php
						echo form_dropdown("lokasi_id", $lokasilist, set_value('lokasi_id'), "class='form-control'
						data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' required");
						?>
						<span class="error"><?php echo form_error('lokasi_id'); ?></span>
					</div>
				</div>
				<div class="col-md-4 mb-sm">
					<div class="form-group <?php if (form_error('jabatan_id')) echo 'has-error'; ?>">
						<label class="control-label">Jabatan <span class="required">*</span></label>
						<?php
						echo form_dropdown("jabatan_id", $jabatanlist, set_value('jabatan_id'), "class='form-control'
						data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' required");
						?>
						<span class="error"><?php echo form_error('jabatan_id'); ?></span>
					</div>
				</div>
				<div class="col-md-4 mb-sm">
					<div class="form-group <?php if (form_error('shift_id')) echo 'has-error'; ?>">
						<label class="control-label">Shift <span class="required">*</span></label>
						<?php
						echo form_dropdown("shift_id", $shiftlist, set_value('shift_id'), "class='form-control'
						data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' required");
						?>
						<span class="error"><?php echo form_error('shift_id'); ?></span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8 mb-sm">
					<div class="form-group <?php if (form_error('nama')) echo 'has-error'; ?>">
						<label class="control-label">Nama Lengkap <span class="required">*</span></label>
						<div class="input-group">
							<span class="input-group-addon"><i class="far fa-user"></i></span>
							<input class="form-control" name="nama" type="text"
								value="<?php echo set_value('nama'); ?>" required>
						</div>
						<span class="error"><?php echo form_error('nama'); ?></span>
					</div>
				</div>
				<div class="col-md-4 mb-sm">
					<div class="form-group <?php if (form_error('notelp')) echo 'has-error'; ?>">
						<label class="control-label">Nomor Telp <span class="required">*</span></label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-tablet"></i></span>
							<input class="form-control" name="notelp" type="text"
								value="<?php echo set_value('notelp'); ?>" required>
						</div>
						<span class="error"><?php echo form_error('notelp'); ?></span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 mb-sm">
					<div class="form-group <?php if (form_error('tempat_lahir')) echo 'has-error'; ?>">
						<label class="control-label">Tempat Lahir</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-home"></i></span>
							<input class="form-control" name="tempat_lahir" type="text"
								value="<?php echo set_value('tempat_lahir'); ?>">
						</div>
						<span class="error"><?php echo form_error('tempat_lahir'); ?></span>
					</div>
				</div>
				<div class="col-md-4 mb-sm">
					<div class="form-group <?php if (form_error('tgl_lahir')) echo 'has-error'; ?>">
						<label class="control-label">Tanggal Lahir</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fas fa-birthday-cake"></i></span>
							<input class="form-control" name="tgl_lahir" autocomplete="off" value="<?=set_value('tgl_lahir')?>" data-plugin-datepicker
									data-plugin-options='{ "startView": 2 }' type="text">
						</div>
						<span class="error"><?php echo form_error('tgl_lahir'); ?></span>
					</div>
				</div>
				<div class="col-md-4 mb-sm">
					<div class="form-group <?php if (form_error('jenis_kelamin')) echo 'has-error'; ?>">
						<label class="control-label">Jenis Kelamin</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fas fa-venus-mars"></i></span>
							<?php
							$gender = $this->app_lib->get_gender();
							echo form_dropdown("jenis_kelamin", $gender, set_value("jenis_kelamin"), "class='form-control populate' data-plugin-selectTwo
							data-width='100%' data-minimum-results-for-search='Infinity'");
							?>
						</div>
						<span class="error"><?php echo form_error('jenis_kelamin'); ?></span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 mb-sm">
					<div class="form-group <?php if (form_error('pendidikan')) echo 'has-error'; ?>">
						<label class="control-label">Pendidikan<span class="required">*</span></label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-graduation-cap"></i></span>
							<?php
							$pendidikan = $this->app_lib->get_pendidikan();
							echo form_dropdown("pendidikan", $pendidikan, set_value("pendidikan"), "class='form-control populate' data-plugin-selectTwo
							data-width='100%' data-minimum-results-for-search='Infinity' required");
							?>
						</div>
						<span class="error"><?php echo form_error('pendidikan'); ?></span>
					</div>
				</div>
				<div class="col-md-4 mb-sm">
					<div class="form-group <?php if (form_error('agama')) echo 'has-error'; ?>">
						<label class="control-label">Agama</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fas fa-praying-hands"></i></span>
							<?php
							$agama = $this->app_lib->get_agama();
							echo form_dropdown("agama", $agama, set_value("agama"), "class='form-control populate' data-plugin-selectTwo
							data-width='100%' data-minimum-results-for-search='Infinity'");
							?>
						</div>
						<span class="error"><?php echo form_error('agama'); ?></span>
					</div>
				</div>
				<div class="col-md-4 mb-sm">
					<div class="form-group <?php if (form_error('status_pernikahan')) echo 'has-error'; ?>">
						<label class="control-label">Status Pernikahan</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fas fa-user-friends"></i></span>
							<?php
							$pernikahan = $this->app_lib->get_pernikahan();
							echo form_dropdown("status_pernikahan", $pernikahan, set_value("status_pernikahan"), "class='form-control populate' data-plugin-selectTwo
							data-width='100%' data-minimum-results-for-search='Infinity'");
							?>
						</div>
						<span class="error"><?php echo form_error('status_pernikahan'); ?></span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 mb-sm">
					<div class="form-group <?php if (form_error('gaji_pokok')) echo 'has-error'; ?>">
						<label class="control-label">Gaji Pokok <span class="required">*</span></label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fas fa-money-bill-wave"></i></span>
							<input class="form-control" name="gaji_pokok" id='nominal' type="text"
								value="<?php echo set_value('gaji_pokok'); ?>" required>
						</div>
						<span class="error"><?php echo form_error('gaji_pokok'); ?></span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 mb-sm">
					<div class="form-group <?php if (form_error('alamat')) echo 'has-error'; ?>">
						<label class="control-label">Alamat<span class="required">*</span></label>
						<textarea class="form-control" rows="3" name="alamat"
							placeholder="Alamat Rumah" required><?php echo set_value('alamat'); ?></textarea>
						<span class="error"><?php echo form_error('alamat'); ?></span>
					</div>
				</div>
			</div>
			<div class="form-group mb-md">
				<label class="control-label">Photo</label>
				<input type="file" name="user_photo" data-height="90" class="dropify"
					data-allowed-file-extensions="jpg png bmp" />
			</div>
		</div>
		<footer class="panel-footer">
			<div class="text-right">
				<button type="submit" class="btn btn-default">Simpan</button>
				<button class="btn btn-default modal-dismiss">Batal</button>
			</div>
		</footer>
		<?php echo form_close();?>
	</section>
</div>
<?php } ?>


<script type="text/javascript">
	$(document).ready(function () {
		$(document).on('click', '.add_pegawai', function () {
			mfp_modal('#add_modal');
		});
	});
</script>