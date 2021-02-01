<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title">Filter Data</h4>
	</header>
    <?php echo form_open($this->uri->uri_string(), array('class' => 'validate')); ?>
		<div class="panel-body">
			<div class="row mb-sm">
				<div class="col-md-6 mb-sm">
					<div class="form-group">
						<label class="control-label">Jabatan <span class="required">*</span></label>
	                    <?php
						echo form_dropdown("jabatan_id", $jabatanlist, set_value('jabatan_id'), "class='form-control' data-plugin-selectTwo
						data-width='100%' data-minimum-results-for-search='Infinity'");
						?>
						<span class="error"><?php echo form_error('jabatan_id'); ?></span>
					</div>
				</div>
				<div class="col-md-6 mb-sm">
					<div class="form-group <?php if (form_error('tanggal')) echo 'has-error'; ?>">
						<label class="control-label">Tanggal <span class="required">*</span></label>
						<div class="input-group">
							<input type="text" class="form-control" data-plugin-datepicker name="tanggal" value="<?php echo set_value('tanggal', date("Y-m-d")); ?>" required />
							<span class="input-group-addon"><i class="fas fa-calendar-check"></i></span>
						</div>
						<span class="error"><?php echo form_error('tanggal'); ?></span>
					</div>
				</div>
			</div>
		</div>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-offset-10 col-md-2">
					<button type="submit" name="search" value="1" class="btn btn btn-default btn-block"> <i class="fas fa-filter"></i> Filter</button>
				</div>
			</div>
		</footer>
	<?php echo form_close(); ?>
</section>

<?php if (isset($stafflist)): ?>
	<section class="panel">
    <?php echo form_open($this->uri->uri_string(), array('class' => 'validate')); ?>
		<input type="hidden" name="tanggal" value="<?php echo html_escape($tanggal)?>">
		<header class="panel-heading">
			<h4 class="panel-title"><i class="fas fa-users"></i> Data Pegawai</h4>
		</header>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-offset-9 col-md-3">
					<div class="form-group mb-sm">
						<label class="control-label">Ceklis Semua</label>
						<select name="selectall" class="form-control" data-plugin-selectTwo data-width="100%" data-minimum-results-for-search="Infinity" onchange="fn_select_all(this.value)">
							<option value="">Pilih</option>
							<option value="1">Masuk</option>
							<option value="2">Tidak Masuk</option>
							<option value="3">Cuti</option>
							<option value="4">Terlambat</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive mb-sm mt-xs">
						<table class="table table-bordered table-hover table-condensed tbr-middle mb-none">
							<thead>
								<tr>
									<th>No.</th>
									<th>Nama Pegawai</th>
									<th>ID Pegawai</th>
									<th>Jabatan</th>
									<th class="min-w-xlg">Status</th>
									<th class="min-w-sm">Keterangan</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$count = 1;
								if(count($stafflist)){
									foreach ($stafflist as $key => $row):
									?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo html_escape($row['nama_pegawai']); ?></td>
									<td><?php echo html_escape($row['idpegawai']); ?></td>
									<td><?php echo html_escape($row['nama_jabatan']); ?></td>
									<td>
										<input type="hidden" name="attendance[<?php echo ($key); ?>][pegawai_id]" value="<?php echo html_escape($row['id']); ?>">
										<input type="hidden" name="attendance[<?php echo ($key); ?>][old_absen_id]" value="<?php echo html_escape($row['absensi_id']); ?>">
										<div class="radio-custom radio-success radio-inline">
											<input type="radio" class="spresent" <?php echo ($row['status_absen'] == 'P' ? 'checked' : ''); ?> name="attendance[<?php echo $key; ?>][status]" id="present<?php echo $key; ?>" value="P">
											<label for="present<?php echo $key; ?>">Masuk</label>
										</div>

										<div class="radio-custom radio-danger radio-inline">
											<input type="radio" class="sabsent" <?php echo ($row['status_absen'] == 'A' ? 'checked' : ''); ?> name="attendance[<?php echo $key; ?>][status]" id="absent<?php echo $key; ?>" value="A">
											<label for="absent<?php echo $key; ?>">Tidak Masuk</label>
										</div>

										<div class="radio-custom radio-info radio-inline">
											<input type="radio" class="sholiday" <?php echo ($row['status_absen'] == 'H' ? 'checked' : ''); ?> name="attendance[<?php echo $key; ?>][status]" id="holiday<?php echo $key; ?>" value="H">
											<label for="holiday<?php echo $key; ?>">Cuti</label>
										</div>

										<div class="radio-custom radio-inline">
											<input type="radio" class="slate" <?php echo ($row['status_absen'] == 'L' ? 'checked' : ''); ?> name="attendance[<?php echo $key?>][status]" id="late<?php echo $key; ?>" value="L">
											<label for="late<?php echo $key; ?>">Terlambat</label>
										</div>
									</td>
									<td>
										<input class="form-control" name="attendance[<?php echo $key; ?>][keterangan]" type="text" value="<?php echo $row['keterangan']; ?>" />
									</td>
								</tr>
									<?php
										endforeach;
									}else{
										echo '<tr><td colspan="5"><h5 class="text-danger text-center">Data masih kosong</td></tr>';
									}
									?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="panel-footer">
			<div class="row">
				<div class="col-md-offset-10 col-md-2">
					<button type="submit" class="btn btn-default btn-block" name="attensave" value="1"><i class="fas fa-plus-circle"></i> Simpan Absensi</button>
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
	</section>
<?php endif; ?>
