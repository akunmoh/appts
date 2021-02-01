<div class="row">
		<div class="col-md-12">
			<div class="panel">
				<div class="row widget-row-in">
					<div class="col-lg-3 col-sm-6 ">
						<div class="panel-body">
							<div class="row widget-col-in">
								<div class="col-md-8 col-sm-8 col-xs-8"> <i class="fas fa-restroom"></i>
									<h5 class="text-muted">Penumpang</h5>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-4">
									<h3 class="counter text-right mt-md text-primary"><?= $tot_pnp['total_pnp'];?></h3>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="box-top-line line-color-primary">
										<span class="text-muted text-uppercase">Jumlah Penumpang</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 ">
						<div class="panel-body">
							<div class="row widget-col-in">
								<div class="col-md-4 col-sm-4 col-xs-4"> <i class="fas fa-bus" ></i>
									<h5 class="text-muted">Bus Masuk</h5></div>
								<div class="col-md-8 col-sm-8 col-xs-8">
									<h3 class="counter text-right mt-md text-primary"><?= $tot_bus;?></h3>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="box-top-line line-color-primary">
										<span class="text-muted text-uppercase">Jumlah Bus masuk hari ini</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 ">
						<div class="panel-body">
							<div class="row widget-col-in">
								<div class="col-md-4 col-sm-4 col-xs-4"> <i class="fas fa-bus-alt" ></i>
									<h5 class="text-muted">Dari Barat</h5></div>
								<div class="col-md-8 col-sm-8 col-xs-8">
									<h3 class="counter text-right mt-md text-primary"><?= $barat;?></h3>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="box-top-line line-color-primary">
										<span class="text-muted text-uppercase">Bus dari Barat hari ini</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 ">
						<div class="panel-body">
							<div class="row widget-col-in">
								<div class="col-md-4 col-sm-4 col-xs-4"> <i class="fas fa-bus" ></i>
									<h5 class="text-muted">Dari Timur</h5></div>
								<div class="col-md-8 col-sm-8 col-xs-8">
									<h3 class="counter text-right mt-md text-primary"><?= $timur;?></h3>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="box-top-line line-color-primary">
										<span class="text-muted text-uppercase">Bus dari Timur hari ini</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

    <div class="row">
		<div class="col-md-12">
			<section class="panel">
				<header class="panel-heading">
					<h4 class="panel-title">
						<i class="fa fa-money-check"></i> Data Terbaru
					</h4>
				</header>

				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-condensed" cellspacing="0" width="100%">
							<thead>
								<tr>
								<th>No.</th>
								<th>Nomor Bodi</th>
								<th>Nomor Polisi</th>
								<th>Nama Sopir</th>
								<th>Jml Pnp</th>
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
		</div>
	</div>
