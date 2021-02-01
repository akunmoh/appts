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
				</div>
			</div>
			<div class="col-md-6 mb-sm">
				<div class="form-group">
					<label class="control-label">Bulan <span class="required">*</span></label>
					<div class="input-group">
						<input type="text" class="form-control" name="timestamp"
							value="<?php echo set_value('timestamp', date('Y-F')); ?>" data-plugin-datepicker required
							data-plugin-options='{"format": "yyyy-MM", "minViewMode": "months"}' />
						<span class="input-group-addon"><i class="fas fa-calendar-check"></i></span>
					</div>
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

<?php if (isset($pegawailist)) { ?>
<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"><i class="far fa-chart-bar"></i> Laporan Absensi Bulan: <?=bulan($bulan). ' ' .$tahun;?></h4>
		<div class="panel-btn">
			<a href="#" onClick="fn_printElem('invoice_print')" class="btn btn-default btn-sm"><i class="fas fa-print"></i>
				Cetak</a>
		</div>
	</header>
	<div class="panel-body">
		<div class="row mt-sm">
			<div class="col-md-offset-8 col-md-4">
				<table class="table table-condensed table-bordered text-dark text-center">
					<tbody>
						<tr>
							<td>Masuk : <i class="far fa-check-circle text-success"></i></td>
							<td>Tidak Masuk : <i class="far fa-times-circle text-danger"></i></td>
							<td>Cuti : <i class="fas fa-procedures text-warning"></i></td>
							<td>Terlambat : <i class="far fa-clock text-tertiary"></i></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
			<div id="invoice_print">
				<div class="export_title"><h3>Laporan Absensi Bulan: <?=bulan($bulan). ' ' .$tahun;?></h3></div>
				<table class="table table-bordered table-hover table-condensed" cellspacing="0" width="100%"
					id="table-export">
					<thead>
						<tr>
							<td>Nama Pegawai</td>
							<?php
							for($i = 1; $i <= $hari; $i++){
								$tanggal = $tahun . '-' . $bulan . '-' . $i;
							?>
							<td class="text-center"><?php echo hari(date('D', strtotime($tanggal))); ?> <br>
								<?php echo date('d', strtotime($tanggal)); ?></td>
							<?php } ?>
							<td class="text-center">Total<br> Masuk</td>
							<td class="text-center">Total<br> Tidak Masuk</td>
							<td class="text-center">Total<br> Terlambat</td>
						</tr>
					</thead>
					<tbody>
						<?php
						$total_present = 0;
						$total_absent = 0;
						$total_late = 0;

						if(count($pegawailist)){ foreach ($pegawailist as $row){ ?>
						<tr>
							<td><?php echo html_escape($row['nama']); ?></td>
							<?php
							for ($i = 1; $i <= $hari; $i++) { 
							$tanggal = date('Y-m-d', strtotime($tahun . '-' . $bulan . '-' . $i));
							$absen = $this->absensi_model->absen_by_date($row['id'], $tanggal);
							?>
							<td class="center">
								<?php if (!empty($absen)) { ?>
								<span data-toggle="popover" data-trigger="hover" data-placement="top"
									data-trigger="hover"
									data-content="<?php echo html_escape($absen['keterangan']); ?>">
									<?php if ($absen['status'] == 'A') { $total_absent++; ?>
									<i class="far fa-times-circle text-danger"></i><span class="visible-print">A</span>
									<?php } if ($absen['status'] == 'P') { $total_present++; ?>
									<i class="far fa-check-circle text-success"></i><span class="visible-print">M</span>
									<?php } if ($absen['status'] == 'L') { $total_late++; ?>
									<i class="far fa-clock text-tertiary"></i><span class="visible-print">T</span>
									<?php } if ($absen['status'] == 'H'){ ?>
									<i class="fas fa-procedures text-warning"></i><span
										class="visible-print">L</span>
									<?php } ?>
								</span>
								<?php } ?>
							</td>
							<?php } ?>
							<td class="center"><?php echo ($total_present);?></td>
							<td class="center"><?php echo ($total_absent);?></td>
							<td class="center"><?php echo ($total_late);?></td>
						</tr>
						<?php } } ?>
					</tbody>
				</table>
			</div>
			</div>
		</div>
	</div>
</section>
<?php } ?>