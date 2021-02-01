<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"> Filter Laporan</h4>
	</header>
	<?php echo form_open($this->uri->uri_string()); ?>
	<div class="panel-body">
		<div class="row mb-sm">
			<div class="col-md-offset-3 col-md-3 mb-sm">
				<div class="form-group">
					<label class="control-label">Lokasi Tujuan</label>
					<?=form_dropdown("lokasi_id", $lokasilist, set_value("lokasi_id"), "class='form-control' data-plugin-selectTwo id='lokasi_id' data-width='100%' ");
						?>
				</div>
			</div>
			<div class="col-md-3 mb-sm">
				<div class="form-group <?php if (form_error('daterange')) echo 'has-error'; ?>">
					<label class="control-label">Tanggal <span class="required">*</span></label>
					<div class="input-group">
						<input type="text" class="form-control daterange" name="daterange"
						value="<?php echo set_value('daterange', date("Y/m/d") . ' - ' . date("Y/m/d")); ?>" required />
						<span class="input-group-addon"><i class="icon-event icons"></i></span>
					</div>
					<span class="error"><?=form_error('daterange')?></span>
				</div>
			</div>
		</div>
	</div>
	<footer class="panel-footer">
		<div class="row">
			<div class="col-md-offset-10 col-md-2">
				<button type="submit" name="search" value="1" class="btn btn btn-default btn-block"> <i
						class="fas fa-filter"></i> Filter</button>
			</div>
		</div>
	</footer>
	<?php echo form_close(); ?>
</section>

<?php if (isset($lapkeluar)): ?>
<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"><i class="fas fa-list-ol"></i> Laporan Barang Keluar</h4>
	</header>
	<div class="panel-body">
		<div class="export_title">Laporan Barang Keluar : <?php echo _d($daterange[0]); ?> To <?php echo _d($daterange[1]); ?>
		</div>
		<table class="table table-bordered table-hover table-condensed table-export" cellspacing="0" width="100%"
			id="table-export">
			<thead>
				<tr>
					<th width="5%" class="text-center">No.</th>
					<th>Lokasi</th>
					<th>Nama Barang</th>
					<th>Kategori</th>
					<th>Tanggal</th>
					<th>Jumlah Keluar</th>
					<th>Staff</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$count = 1;
				if(!empty($lapkeluar)) {
					foreach ($lapkeluar as $row):
				?>
				<tr>
					<td class="text-center"><?php echo $count++; ?></td>
					<td><?php echo html_escape($row['nama_lokasi']); ?></td>
					<td><?php echo html_escape($row['nama_barang']); ?></td>
					<td><?php echo html_escape($row['nama_kategori']); ?></td>
					<td><?php echo html_escape(date_indo($row['tanggal'])); ?></td>
					<td class="text-center"><?php echo html_escape($row['jumlah']); ?></td>
					<td><?php echo html_escape($row['nama_staff']); ?></td>
				</tr>
				<?php endforeach; }?>
			</tbody>

		</table>
	</div>
</section>
<?php endif; ?>