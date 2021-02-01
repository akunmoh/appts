<header class="panel-heading">
	<h4 class="panel-title">
		<i class="fas fa-list-ul"></i> Slip Gaji Karyawan
	</h4>
	<div class="panel-btn">
		<a href="#" onClick="fn_printElem('invoice_print')" class="btn btn-default btn-sm"><i class="fas fa-print"></i>
			Cetak</a>
		<button class="btn btn-default btn-sm modal-dismiss"><i class="fas fa-times"></i></button>
	</div>
</header>

<div class="panel-body">
	<div id="invoice">
		<div id="invoice_print">
			<div class="invoice">
				<header class="clearfix">
					<div class="row">
						<div class="col-xs-6">
							<div class="ib">
								<img src="<?php echo base_url('uploads/app_image/printing-logo.png'); ?>" alt="Img" />
							</div>
						</div>
						<div class="col-xs-6 text-right">
							<h4 class="mt-none text-dark">Payslip No #<?php echo html_escape($slipgaji['id']); ?></h4>
							<p class="mb-none">
								<span class="text-dark">Gaji Bulan : </span>
								<?php echo  bulan($slipgaji['bulan']).'-'.$slipgaji['tahun']; ?>
							</p>
							<p class="mb-none">
								<span class="text-dark">Cetak Tanggal : </span> <span
									class="value"><?php echo date_indo($slipgaji['tanggal']); ?></span>
							</p>
						</div>
					</div>
				</header>
				<div class="bill-info">
					<div class="row">
						<div class="col-xs-6">
							<div class="bill-data">
								<p class="h5 mb-xs text-dark text-weight-semibold">Diberikan Kepada :</p>
								<address>
									<?php echo $slipgaji['nama_pegawai']; ?><br>
									Jabaran : <?php echo $slipgaji['nama_jabatan']; ?><br>
									No. Telp : <?php echo $slipgaji['no_telp']; ?>
								</address>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="bill-data text-right">
								<p class="h5 mb-xs text-dark text-weight-semibold"><?=$global_config['nama_app'];?></p>
								<address>
									<?php
								echo $global_config['alamat']. "<br/>";
								echo $global_config['telp'] . "<br/>";
								?>
								</address>
							</div>
						</div>
					</div>
				</div>

				
					<table>
						<tr>
							<td>
								<section class="panel panel-custom">
									<div class="panel-heading panel-heading-custom">
										<h4 class="panel-title">Tambahan</h4>
									</div>
									<div class="panel-horizontal">
										<div class="text-dark">
											<table class="table">
												<thead>
													<tr>
														<th>Keterangan</th>
														<th class="text-right">Nominal</th>
													</tr>
												</thead>
												<tbody>
													<?php
											$total_allowance = 0;
											$allowances = $this->penggajian_model->get_list('gaji_tunjangan', array('gaji_id' => $slipgaji['id'], 'jenis' => 'tambahan'));
											if(count($allowances)){
												foreach ($allowances as $allowance):
													$total_allowance += $allowance['nominal'];
										?>
													<tr>
														<td><?php echo html_escape($allowance['keterangan']); ?></td>
														<td class="text-right">
															<?php echo number_format($allowance['nominal'], 0, ',', '.'); ?>
														</td>
													</tr>
													<?php endforeach; } else {
											echo '<tr> <td colspan="2"> <h5 class="text-danger text-center">Tidak ada penambahan</h5> </td></tr>';
										 }; ?>
												</tbody>
											</table>
										</div>
									</div>
								</section>

							</td>
							<td>&nbsp;</td>
							<td>

								<section class="panel panel-custom">
									<div class="panel-heading panel-heading-custom">
										<h4 class="panel-title">Pengurangan</h4>
									</div>
									<div class="panel-horizontal">
										<div class="table-responsive text-dark">
											<table class="table">
												<thead>
													<tr>
														<th>Keterangan</th>
														<th class="text-right">Nominal</th>
													</tr>
												</thead>
												<tbody>
													<?php
											$total_deduction = 0;
											$deductions = $this->penggajian_model->get_list('gaji_tunjangan', array('gaji_id' => $slipgaji['id'], 'jenis' => 'potongan'));
											if(count($deductions)){
												foreach ($deductions as $deduction):
													$total_deduction += $deduction['nominal'];
										?>
													<tr>
														<td><?php echo html_escape($deduction['keterangan']); ?></td>
														<td class="text-right">
															<?php echo number_format($deduction['nominal'], 0, ',', '.'); ?>
														</td>
													</tr>
													<?php 
												endforeach; 
											}else{
											
												echo '<tr> <td colspan="2"> <h5 class="text-danger text-center">Tidak ada pengurangan</h5> </td></tr>';
											};
										 ?>
												</tbody>
											</table>
										</div>
									</div>
								</section>
							</td>
						</tr>
					</table>
				

				<div class="invoice-summary text-right">
					<div class="row">
						<div class="col-md-5 pull-right">
							<ul class="amounts">
								<li><strong>Gaji Pokok :</strong> Rp
									<?=number_format($slipgaji['gaji_pokok'], 0, ',', '.'); ?></li>
								<li><strong>Total Tambahan :</strong> Rp
									<?=number_format($slipgaji['tambahan'], 0, ',', '.'); ?></li>
								<li><strong>Total Potongan :</strong> Rp
									<?=number_format($slipgaji['potongan'], 0, ',', '.'); ?></li>
								<li>
									<strong>Total Gaji : </strong> Rp
									<?php
								$f = new NumberFormatter("id", NumberFormatter::SPELLOUT);
								echo number_format($slipgaji['total_gaji'], 0, ',', '.') . ' </br>(' . strtoupper($f->format($slipgaji['total_gaji'])) . ')' ;
								?>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="row mt-xxlg">
					<div class="col-xs-6">
						<div class="text-left">
							<!-- <?php echo "Dibuat oleh - " . $slipgaji['nama_staff']; ?> -->
						</div>
					</div>
					<div class="col-md-6">
						<div class="auth-signatory">
							[ Penanggung Jawab ]
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>