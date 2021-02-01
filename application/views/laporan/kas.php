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

<?php if (isset($jurnal)): ?>
<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"><i class="fas fa-list-ol"></i> Laporan Kas</h4>
	</header>
	<div class="panel-body">
		<div class="export_title">Laporan Kas : <?php echo _d($daterange[0]); ?> To <?php echo _d($daterange[1]); ?>
		</div>
		<table class="table table-bordered table-hover table-condensed table-export" cellspacing="0" width="100%"
			id="table-export">
			<thead>
				<tr>
					<th width="50" class="text-center">No.</th>
					<th>Tanggal</th>
					<th>No.Bukti</th>
					<th>Uraian</th>
					<th class="text-center">Debit</th>
					<th class="text-center">Kredit</th>
					<th class="text-center">Saldo</th>
				</tr>
			</thead>
			<tbody>
				<?php
                $_saldo = 0;
                foreach ($saldo_awal as $s) :
                    if ($s['debit'] == 0) {
                        $nominal = $s['kredit'];
                        $_saldo = $_saldo - $nominal;
                    } else {
                        $nominal = $s['debit'];
                        $_saldo = $_saldo + $nominal;
                    }
                endforeach;
                ?>
				<tr>
					<th class="text-center" scope="row">-</th>
					<td>-</td>
					<td>-</td>
					<td><b>Saldo Kas Akhir</b></td>
					<td style="text-align:right;">-</td>
					<td style="text-align:right;">-</td>
					<td style="text-align:right;"><b>Rp <?= number_format($_saldo, 0, ',', '.') ?></b></td>
				</tr>

				<?php
                if ($_saldo != 0) {
                    $saldo = $_saldo;
                } else {
                    $saldo = 0;
                }
				$i = 1;
				$total_dr = 0;
				$total_cr = 0;
                foreach ($jurnal as $row) :
                    if ($row['debit'] == 0) {
                        $nominal = $row['kredit'];
                        $saldo = $saldo - $nominal;
                    } else {
                        $nominal = $row['debit'];
                        $saldo = $saldo + $nominal;
                    }
                ?>

				<tr>
					<th class="text-center" scope="row"><?= $i ?></th>
					<td><?= date_indo($row['tanggal']) ?></td>
					<td><?= $row['reff_no'] ?></td>
					<td><?= $row['keterangan'] ?></td>
					<td style="text-align:right;"><?= number_format($row['debit'], 0, ',', '.') ?></td>
					<td style="text-align:right;"><?= number_format($row['kredit'], 0, ',', '.') ?></td>
					<td style="text-align:right;">Rp <?= number_format($saldo, 0, ',', '.') ?>
					</td>
				</tr>
				<?php $i++;
                endforeach ?>
			</tbody>

		</table>
	</div>
</section>
<?php endif; ?>