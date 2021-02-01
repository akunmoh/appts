<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"><i class="fas fa-search"></i> Filter Data</h4>
	</header>
	<?=form_open($this->uri->uri_string(), array('class' => 'validate')); ?>
	<div class="panel-body">
		<div class="row mb-sm">
			<div class="col-md-offset-3 col-md-3 mb-sm">
				<div class="form-group">
					<label class="control-label">Jabatan</label>
					<?php
					echo form_dropdown("jabatan_id", $jabatanlist, set_value('jabatan_id'), "class='form-control' data-plugin-selectTwo
					data-width='100%' data-minimum-results-for-search='Infinity'");
					?>
				</div>
			</div>
			<div class="col-md-3 mb-sm">
				<div class="form-group <?php if (form_error('tanggal')) echo 'has-error'; ?>">
					<div class="form-group">
						<label class="control-label">Bulan <span class="required">*</span></label>
						<input type="text" class="form-control monthyear" name="month_year"
							value="<?php echo set_value('month_year',date("Y-m")); ?>" required />
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

<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"><i class="fas fa-list-ul"></i> Manage Penggajian</h4>
	</header>
	<div class="panel-body">
		<div class="export_title">Penggajian Bulan :
			<?php echo $this->app_lib->get_months_list($bulan) . " - " . $tahun; ?></div>
		<table class="table table-bordered table-hover" cellspacing="0" width="100%"
			id="table-export">
			<thead>
				<tr>
					<th class="text-center">No</th>
					<th>Nama Pegawai</th>
					<th>Jabatan</th>
					<th>Pendidikan</th>
					<th>Alamat</th>
					<th>No Telp</th>
					<th class="text-center">Status</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$count = 1;
				if (count($payslip)) {
					foreach ( $payslip as $row ):
					$status = $row["status"];
                    if ($row["status"] == "dibayar") {
                        $label = "class='label label-success'";
                        $wstatus = 'Sudah Dibayarkan';
					} else if ($row["status"] == "dihitung") {
                        $label = "class='label label-warning'";
                        $wstatus = 'Sudah Dihitung';
                    } else {
                        $label = "class='label label-default'";
                        $wstatus = 'Belum Dihitung';
                    }
				?>
				<tr>
					<td class="text-center"><?php echo $count++; ?></td>
					<td><?php echo html_escape($row['nama']); ?></td>
					<td><?php echo html_escape($row['nama_jabatan']); ?></td>
					<td><?php echo html_escape($row['pendidikan']); ?></td>
					<td><?php echo html_escape($row['alamat']); ?></td>
					<td><?php echo html_escape($row['notelp']); ?></td>
					<td class="text-center"><small <?php echo $label; ?>><?php echo $wstatus; ?></small></td>
				</tr>
				<?php endforeach; } ?>
			</tbody>

		</table>
	</div>
</section>