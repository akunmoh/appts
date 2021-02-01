<div class="dashboard-page">
	<?php 
	if (is_gudang_loggedin()) {
		$this->load->view('beranda/gudang.php');
	}elseif(is_posj_loggedin()){
		$this->load->view('beranda/po_sinar.php');
	}elseif(is_pononsj_loggedin()){
		$this->load->view('beranda/po_non_sinar.php');
	}else{
	?>
	<?php if(get_permission('widget_admin', 'is_view')){ ?>
	<div class="row">
		<div class="col-md-12">
			<div class="panel">
				<div class="row widget-row-in">
					<div class="col-lg-3 col-sm-6 ">
						<div class="panel-body">
							<div class="row widget-col-in">
								<div class="col-md-8 col-sm-8 col-xs-8"> <i class="fas fa-user-friends"></i>
									<h5 class="text-muted">Jumlah Pegawai</h5>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-4">
									<h3 class="counter text-right mt-md text-primary"><?php echo $get_total_pegawai; ?></h3>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="box-top-line line-color-primary">
										<span class="text-muted text-uppercase">Jumlah Pegawai</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 ">
						<div class="panel-body">
							<div class="row widget-col-in">
								<div class="col-md-4 col-sm-4 col-xs-4"> <i class="fas fa-donate" ></i>
									<h5 class="text-muted">Pemasukkan</h5></div>
								<div class="col-md-8 col-sm-8 col-xs-8">
									<h3 class="counter text-right mt-md text-primary"><?php echo $get_pendapatan_pengeluaran['total_pemasukkan']; ?></h3>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="box-top-line line-color-primary">
										<span class="text-muted text-uppercase">Pemasukkan Hari Ini</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 ">
						<div class="panel-body">
							<div class="row widget-col-in">
								<div class="col-md-4 col-sm-4 col-xs-4"> <i class="fas fa-wallet" ></i>
									<h5 class="text-muted">Pengeluaran</h5></div>
								<div class="col-md-8 col-sm-8 col-xs-8">
									<h3 class="counter text-right mt-md text-primary"><?php echo html_escape($get_pendapatan_pengeluaran['total_pengeluaran']); ?></h3>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="box-top-line line-color-primary">
										<span class="text-muted text-uppercase">Pengeluaran Hari Ini</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 ">
						<div class="panel-body">
							<div class="row widget-col-in">
								<div class="col-md-4 col-sm-4 col-xs-4"> <i class="far fa-money-bill-alt" ></i>
									<h5 class="text-muted">Saldo KAS</h5></div>
								<div class="col-md-8 col-sm-8 col-xs-8">
									<h3 class="counter text-right mt-md text-primary"><?php echo $saldo['total_saldo']; ?></h3>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="box-top-line line-color-primary">
										<span class="text-muted text-uppercase">Saldo KAS Saat Ini</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	
	<?php if(get_permission('grafik_bulanan', 'is_view')){ ?>
	<div class="row">
		<div class="col-md-12">
			<section class="panel">
				<div class="panel-body">
					<h2 class="chart-title mb-md">Grafik Bulan <?php echo bulan(date("m")) .' ' .date("Y"); ?></h2>
					<div class="pe-chart">
						<canvas id="GrafikBulanan" style="height: 324px;"></canvas>
					</div>
				</div>
			</section>
		</div>
	</div>
	<?php } ?>

	<?php if(get_permission('grafik_tahunan', 'is_view')){ ?>
	<div class="row">
		<div class="col-md-12">
			<section class="panel">
				<div class="panel-body">
					<h2 class="chart-title mb-md">Grafik Tahun <?php echo date("Y"); ?></h2>
					<div class="pe-chart">
						<canvas id="GrafikTahunan" style="height: 328px;"></canvas>
					</div>
				</div>
			</section>
		</div>
	</div>
	<?php } ?>

<?php } ?>
</div>

<script type="application/javascript">
	// untuk data bulanan
	var tgl = <?php echo json_encode($grafik_bulanan['tgl']); ?>;
	var net_pemasukkan = <?php echo json_encode($grafik_bulanan['total_pemasukkan']); ?>;
	var net_pengeluaran = <?php echo json_encode($grafik_bulanan['total_pengeluaran']); ?>;
	var GrafikBulanan = {
		type: 'bar',
		data: {
			labels: tgl,
			datasets: [{
				label: "Pendapatan",
				data: net_pemasukkan,
				backgroundColor: 'rgba(0, 136, 204, .8)',
				borderColor: '#F5F5F5',
				borderWidth: 1
			},{
				label: "Pengeluaran",
				data: net_pengeluaran,
				backgroundColor: 'rgba(216, 27, 96, .8)',
				borderColor: '#F5F5F5',
				borderWidth: 1
			}]
		},
		options: {
			responsive: true,
			stacked: false,
			tooltips: {
				mode: 'index',
				bodySpacing: 4
			},
			title: {
				display: false,
				text: 'Pendapatan Pengeluaran'
			},
			legend: {
				position: 'bottom',
				labels: { boxWidth: 12 }
			}
		}
	};

	// Untuk data tahunan
	var pemasukkan = <?php echo json_encode($grafik_tahunan['pemasukkan']); ?>;
	var pengeluaran = <?php echo json_encode($grafik_tahunan['pengeluaran']); ?>;

	var GrafikTahunan = {
		type: 'line',
		data: {
			labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
			datasets: [
				{
					label: "Pendapatan",
					backgroundColor: 'rgba(0, 136, 204, .7)',
					borderColor: '#F5F5F5',
					borderWidth: 1,
					data: pemasukkan
				},
				{
					label: "Pengeluaran",
					backgroundColor: 'rgba(204, 61, 61, 0.7)',
					borderColor: '#F5F5F5',
					borderWidth: 1,
					data: pengeluaran
				}
			]
		},
		options: {
			responsive: true,
			title: {
				display: false,
				text: 'Grafik Pendapatan dan Pengeluaran Per Tahun'
			},
			legend: {
		 		position: 'bottom',
		 		labels: { boxWidth: 12 }
			},
			scales: {
				xAxes: [{
					stacked: true,
					scaleLabel: {
						display: false,
					}
				}],
				yAxes: [{
					display: true,
					beginAtZero: false
				}]
			}
		}

	};

	window.onload = function() {
	// grafik bulanan
	var ctx2 = document.getElementById('GrafikBulanan').getContext('2d');
	window.myBar = new Chart(ctx2, GrafikBulanan);
	// grafik tahunan
	var ctx = document.getElementById('GrafikTahunan').getContext('2d');
	window.myLine =new Chart(ctx, GrafikTahunan);
	};
</script>