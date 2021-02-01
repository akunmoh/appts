<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"><i class="fas fa-search"></i> Filter Laporan</h4>
	</header>
	<?=form_open($this->uri->uri_string(), array('class' => 'validate')); ?>
	<div class="panel-body">
		<div class="row mb-sm">
			<div class="col-md-offset-3 col-md-3 mb-sm">
				<div class="form-group">
					<label class="control-label">Nama P.O</label>
					<?php
						echo form_dropdown("po_id", $po_list, set_value('po_id'), "class='form-control' data-plugin-selectTwo
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
	<?=form_close(); ?>
</section>

<?php if (isset($data_bus)) { ?>
<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"><i class="fas fa-list-ul"></i> Laporan P.O Bus <?php echo _po($po_id).' - Tanggal '.tgl_indo($tanggal); ?></h4>
		<div class="panel-btn">
			<a href="#" onClick="fn_printElem('invoice_print')" class="btn btn-default btn-sm"><i class="fas fa-print"></i>
				Cetak</a>
		</div>
	</header>
	<div id="invoice_print">
	<div class="panel-body">
		<div class="export_title"><h2>Laporan P.O Bus <?php echo _po($po_id).' - Tanggal '.tgl_indo($tanggal); ?></h2></div>
		<div class="row mt-sm">
			<div class="col-md-offset-8 col-md-4">
				<table class="table table-condensed table-bordered text-dark text-center">
					<tbody>
						<tr>
							<td>Jumlah Penumpang: <?= $tot_pnp['total_pnp'];?></td>
							<td>Bus Masuk: <?= $tot_bus;?></td>
							
							<td>Dari Barat: <?= $barat;?></td>
							<td>Dari Timur: <?= $timur;?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<table class="table table-bordered table-hover" cellspacing="0" width="100%">
			<thead>
				<tr>
                    <th>No.</th>
					<th>Nomor Bodi</th>
                    <th>Nomor Polisi</th>
                    <th>Nama Sopir</th>
                    <th>Jml Penumpang</th>
                    <th>Kedatangan</th>
					<th>Dari</th>
					<th>Tujuan</th>
					<th>Tanggal</th>
					<th>Staff</th>
				</tr>
			</thead>
			<tbody>
				
                <?php $count = 1; if (!empty($data_bus)){ foreach ($data_bus as $row): ?>
				<tr>
					<td class="text-center"><?=$count++; ?></td>
					<td><?php echo $row['no_bodi']; ?></td>
					<td><?php echo $row['no_polisi']; ?></td>
                    <td><?php echo $row['nama_sopir']; ?></td>
                    <td><?php echo $row['jml_pnp']; ?></td>
                    <td><?php echo $row['kedatangan']; ?></td>
                    <td><?php echo $row['dari']; ?></td>
                    <td><?php echo $row['tujuan']; ?></td>
                    <td><?php echo tgl_indo($row['tanggal']); ?></td>
					<td><?php echo $row['nama_staff']; ?></td>
				</tr>
				<?php endforeach; }?>
			</tbody>
		</table>
	</div>
	</div>
</section>
<?php } ?>