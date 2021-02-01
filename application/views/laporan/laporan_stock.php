<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"><i class="fas fa-list-ul"></i> Laproan Stock Barang</h4>
	</header>
	<div class="panel-body">
		<div class="export_title">Laproan Stock Barang</div>
		<table class="table table-bordered table-hover table-condensed table-export" cellspacing="0" width="100%"
			id="table-export">
			<thead>
				<tr>
					<th width="5%" class="text-center">No.</th>
					<th>Kode</th>
					<th>Nama Barang</th>
					<th>Kategori</th>
					<th>Unit</th>
					<th class="text-center">Barang Masuk</th>
					<th class="text-center">Barang Keluar</th>
					<th class="text-center">Stock Tersedia</th>
					<th class="text-center">Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($stocklist)){ $count = 1; foreach($stocklist as $row): ?>
                <?php 
                $selisih = $row['jml_masuk'] - $row['jml_keluar'];
                if($row['stock'] != $selisih){
                    $keterangan = "<span class='label label-danger-custom'>Perlu di Audit (ada yang tidak beres)</span>";
                }else{
                    if($row['stock'] < $row['stock_min']){
                        $keterangan = "<span class='label label-warning-custom'>Stock akan habis</span>";
                    }else{
                        $keterangan = "<span class='label label-success-custom'>Stock Aman</span>";
                    }
                }
                ?>
				<tr>
					<td class="text-center"><?=$count++; ?></td>
					<td><?=$row['kode']; ?></td>
					<td><?=$row['nama']; ?></td>
					<td><?=$row['nama_kategori']; ?></td>
					<td><?=$row['nama_unit']; ?></td>
					<td class="text-center"><?=$row['jml_masuk']; ?></td>
					<td class="text-center"><?=$row['jml_keluar']; ?></td>
					<td class="text-center"><b><?=$row['stock'] .'</b> '. $row['nama_unit']; ?></td>
                    <td class="text-center"><?=$keterangan;?></td>
				</tr>
				<?php endforeach; }?>
			</tbody>
		</table>
	</div>
</section>