<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"><i class="fas fa-search"></i> Filter Kas Keluar</h4>
	</header>
	<?php echo form_open($this->uri->uri_string(), array('class' => 'validate')); ?>
	<div class="panel-body">
		<div class="row mb-sm">
			<div class="col-md-offset-3 col-md-3 mb-sm">
				<div class="form-group">
					<label class="control-label">Sumber Pengeluaran</label>
					<?php
						echo form_dropdown("sumber_id", $sumberlist, set_value('sumber_id'), "class='form-control' data-plugin-selectTwo
						data-width='100%' data-minimum-results-for-search='Infinity'");
					?>
				</div>
			</div>
			<div class="col-md-3 mb-sm">
				<div class="form-group <?php if (form_error('tanggal')) echo 'has-error'; ?>">
					<label class="control-label">Tanggal <span class="required">*</span></label>
					<div class="input-group">
						<input type="text" class="form-control" data-plugin-datepicker name="tanggal"
							value="<?=set_value('tanggal', date("Y-m-d"))?>" />
						<span class="input-group-addon"><i class="icon-event icons"></i></span>
					</div>
					<span class="error"><?=form_error('tanggal')?></span>
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
		<h4 class="panel-title"><i class="fas fa-list-ul"></i> Data Kas Keluar</h4>
	</header>
	<div class="panel-body">
		<div class="export_title">Laporan Data Kas Keluar</div>
		<table class="table table-bordered table-hover table-condensed table-export" cellspacing="0" width="100%"
			id="table-export">
			<thead>
				<tr>
				<th class="text-center">No.</th>
					<th>Kode</th>
					<th>Sumber Pemasukkan</th>
					<th>Nama Pemasukkan</th>
					<th>Tanggal</th>
					<th>Staff</th>
					<th class="text-center">Nominal (Kredit)</th>
				</tr>
			</thead>
			<tbody>
			<?php $total_cr = 0; $count = 1; if (!empty($pengeluaran)){ foreach ($pengeluaran as $row): $total_cr += $row['nominal']; ?>
				<tr>
					<td class="text-center"><?=$count++; ?></td>
					<td><?=$row['kode']; ?></td>
					<td><?=$row['nama_sumber']; ?></td>
					<td><?=$row['nama']; ?></td>
					<td><?=date_indo($row['tanggal']); ?></td>
					<td><?=$row['nama_staff']; ?></td>
					<td class="text-right"><?=number_format($row['nominal'], 0, '.', ','); ?></td>
				</tr>
				<?php endforeach; }?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="6" class="text-right"><b>Total Pengeluaran :</b></th>
					<th class="text-right">Rp <?=number_format($total_cr, 0, '.', ','); ?></th>
				</tr>
			</tfoot>
		</table>
	</div>
</section>