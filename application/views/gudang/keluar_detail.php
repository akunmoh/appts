<section class="panel">
	<div class="tabs-custom">
		<div class="tab-content">
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
									<h4 class="mt-none mb-none text-dark">No Nota #<?php echo $datakeluar['no_nota']; ?></h4>
									<p class="mb-none">
										<span class="text-dark">Tanggal : </span>
										<span class="value"><?php echo date_indo($datakeluar['tanggal']); ?></span>
									</p>
								</div>
							</div>
						</header>
						<div class="bill-info">
							<div class="row">
								<div class="col-xs-6">
									<div class="bill-data">
										<p class="h5 mb-xs text-dark text-weight-semibold">Untuk :</p>
										<address>
											<?php
											echo $datakeluar['nama_lokasi']. '<br>';
											?>
											</address>
									</div>
								</div>
								<div class="col-xs-6">
									<div class="bill-data text-right">
										<p class="h5 mb-xs text-dark text-weight-semibold">Dari :</p>
										<address>
											Bagian Gudang
										</address>
									</div>
								</div>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table invoice-items table-hover mb-none">
								<thead>
									<tr class="text-dark">
										<th id="cell-id" class="text-weight-semibold">#</th>
										<th id="cell-item" class="text-weight-semibold">Nama Barang</th>
										<th id="cell-qty" class="text-weight-semibold">Jumlah</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$count = 1;
										$baranglist = $this->gudang_model->get_list('barang_keluar_detail', array('barangkeluar_id' => $datakeluar['id']));
										foreach ($baranglist as $barang) {
											
									?>
									<tr>
										<td><?php echo $count++; ?></td>
										<td class="text-weight-semibold text-dark"><?php echo get_type_name_by_id('barang', $barang['barang_id']); ?></td>
										<td><?php echo $barang['jumlah']; ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<div class="invoice-summary text-right mt-lg">
							<div class="row">
								<div class="col-md-5 pull-right">
									<ul class="amounts">
										<li>
											<strong>Total (Qty) : </strong>  <?php echo $datakeluar['total']; ?>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="row mt-xxlg">
							<div class="col-xs-6">
								<div class="text-left">
									<?php echo "Dibuat oleh - " . $datakeluar['nama_staff']; ?>
								</div>
							</div>
							<div class="col-md-6">
								<div class="auth-signatory">
									[ Penanggung Jawab ]
								</div>
							</div>
						</div>
					</div>
					<div class="text-right mr-lg hidden-print">
						<button class="btn btn-default ml-sm" onClick="fn_printElem('invoice_print')"><i class="fas fa-print"></i> Print</button>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>