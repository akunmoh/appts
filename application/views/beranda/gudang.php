    <div class="row">
		<div class="col-md-12">
			<div class="panel">
				<div class="row widget-row-in">
					<div class="col-lg-3 col-sm-6 ">
						<div class="panel-body">
							<div class="row widget-col-in">
								<div class="col-md-8 col-sm-8 col-xs-8"> <i class="fas fa-dolly-flatbed"></i>
									<h5 class="text-muted">Jumlah Barang</h5>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-4">
									<h3 class="counter text-right mt-md text-primary"><?php echo $get_total_barang; ?></h3>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="box-top-line line-color-primary">
										<span class="text-muted text-uppercase">Jumlah Barang</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 ">
						<div class="panel-body">
							<div class="row widget-col-in">
								<div class="col-md-4 col-sm-4 col-xs-4"> <i class="fas fa-box" ></i>
									<h5 class="text-muted">Barang Masuk</h5></div>
								<div class="col-md-8 col-sm-8 col-xs-8">
									<h3 class="counter text-right mt-md text-primary"><?php echo $get_masuk['stock_masuk']; ?></h3>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="box-top-line line-color-primary">
										<span class="text-muted text-uppercase">Barang Masuk Bulan Ini</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 ">
						<div class="panel-body">
							<div class="row widget-col-in">
								<div class="col-md-4 col-sm-4 col-xs-4"> <i class="fas fa-box-open" ></i>
									<h5 class="text-muted">Barang Keluar</h5></div>
								<div class="col-md-8 col-sm-8 col-xs-8">
									<h3 class="counter text-right mt-md text-primary"><?php echo $get_keluar['stock_keluar']; ?></h3>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="box-top-line line-color-primary">
										<span class="text-muted text-uppercase">Barang Keluar Bulan Ini</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 ">
						<div class="panel-body">
							<div class="row widget-col-in">
								<div class="col-md-4 col-sm-4 col-xs-4"> <i class="fas fa-boxes" ></i>
									<h5 class="text-muted">Jumlah Stock</h5></div>
								<div class="col-md-8 col-sm-8 col-xs-8">
									<h3 class="counter text-right mt-md text-primary"><?php echo $get_stock['jumlah_stock']; ?></h3>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="box-top-line line-color-primary">
										<span class="text-muted text-uppercase">Jumlah Stock Barang</span>
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
						<i class="fa fa-money-check"></i> Barang Stock Kurang
					</h4>
				</header>

				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-condensed" cellspacing="0" width="100%">
							<thead>
								<tr>
                                    <th width="5%" class="text-center">No.</th>
                                    <th>Kode</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <th>Unit</th>
                                    <th class="text-center">Stock Tersedia</th>
								</tr>
							</thead>
							<tbody>
                                <?php if(!empty($stocklimit)){ $count = 1; foreach($stocklimit as $row): ?>
                                <?php if($row['stock'] < $row['stock_min']){ ?>
                                <tr>
                                    <td class="text-center"><?=$count++; ?></td>
                                    <td><?=$row['kode']; ?></td>
                                    <td><?=$row['nama']; ?></td>
                                    <td><?=$row['nama_kategori']; ?></td>
                                    <td><?=$row['nama_unit']; ?></td>
                                    <td class="text-center"><b><?=$row['stock'] .'</b> '. $row['nama_unit']; ?></td>
                                </tr>
                                <?php } ?>
                                <?php endforeach; }?>
							</tbody>
						</table>
					</div>
				</div>
			</section>
		</div>
	</div>

    <div class="row">
        <div class="col-md-6">
            <section class="panel">
                <header class="panel-heading">
                    <h4 class="panel-title"><i class="fas fa-box"></i> Data Barang Masuk Terbaru</h4>
                </header>
                <div class="panel-body">
                    <table class="table table-bordered table-hover table-condensed" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No.</th>
                                <th>Kategori</th>
                                <th>Nama Barang</th>
                                <th>Jml Stok</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            if(!empty($masuklist)) {
                                foreach ($masuklist as $row):
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $count++; ?></td>
                                <td><?php echo html_escape($row['nama_kategori']); ?></td>
                                <td><?php echo html_escape($row['nama_barang']); ?></td>
                                <td><?php echo html_escape($row['stock_qty']); ?></td>
                                <td><?php echo html_escape(date_indo($row['tanggal'])); ?></td>
                            </tr>
                            <?php endforeach; }?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <div class="col-md-6">
            <section class="panel">
                <header class="panel-heading">
                    <h4 class="panel-title"><i class="fas fa-box-open"></i> Data Barang Keluar Terbaru</h4>
                </header>
                <div class="panel-body">
                    <table class="table table-bordered table-hover table-condensed" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No.</th>
                                <th>Kategori</th>
                                <th>Nama Barang</th>
                                <th>Jml Stok</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            if(!empty($keluarlist)) {
                                foreach ($keluarlist as $row):
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $count++; ?></td>
                                <td><?php echo html_escape($row['nama_kategori']); ?></td>
                                <td><?php echo html_escape($row['nama_barang']); ?></td>
                                <td><?php echo html_escape($row['jumlah']); ?></td>
                                <td><?php echo html_escape(date_indo($row['tanggal'])); ?></td>
                            </tr>
                            <?php endforeach; }?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>