<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"> Filter Laporan</h4>
	</header>
	<?php echo form_open($this->uri->uri_string()); ?>
	<div class="panel-body">
		<div class="col-md-offset-3 col-md-6 mb-lg">
			<div class="form-group">
				<label class="control-label">Tanggal <span class="required">*</span></label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fas fa-calendar-check"></i></span>
					<input type="text" class="form-control daterange" name="daterange"
						value="<?php echo set_value('daterange', date("Y/m/d") . ' - ' . date("Y/m/d")); ?>" required />
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

<?php if (isset($lapmasuk)): ?>
<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"><i class="fas fa-list-ol"></i> Laporan Barang Masuk</h4>
	</header>
	<div class="panel-body">
		<div class="export_title">Laporan Barang Masuk : <?php echo _d($daterange[0]); ?> To <?php echo _d($daterange[1]); ?>
		</div>
		<table class="table table-bordered table-hover table-condensed table-export" cellspacing="0" width="100%"
			id="table-export">
			<thead>
				<tr>
					<th width="5%" class="text-center">No.</th>
					<th>Kategori</th>
					<th>Nama Barang</th>
					<th>Tanggal</th>
					<th>Tambah Stok</th>
					<th>Ditambah Oleh</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$count = 1;
				if(!empty($lapmasuk)) {
					foreach ($lapmasuk as $row):
				?>
				<tr>
					<td class="text-center"><?php echo $count++; ?></td>
					<td><?php echo html_escape($row['nama_kategori']); ?></td>
					<td><?php echo html_escape($row['nama_barang']); ?></td>
					<td><?php echo html_escape(date_indo($row['tanggal'])); ?></td>
					<td><?php echo html_escape($row['stock_qty']); ?></td>
					<td><?php echo html_escape($row['nama_staff']); ?></td>
				</tr>
				<?php endforeach; }?>
			</tbody>

		</table>
	</div>
</section>
<?php endif; ?>