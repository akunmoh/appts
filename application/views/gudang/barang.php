<section class="panel">
	<header class="panel-heading">
		<?php if(get_permission('data_barang', 'is_add')){ ?>
		<div class="panel-btn">
			<a href="javascript:void(0);" class="add_barang btn btn-default btn-circle">
				<i class="fas fa-cart-plus"></i> Tambah Barang
			</a>
		</div>
		<?php } ?>
		<h4 class="panel-title"><i class="fas fa-list-ul"></i> Data Barang</h4>
	</header>
	<div class="panel-body">
		<div class="export_title">Laporan Data Barang</div>
		<table class="table table-bordered table-hover table-condensed table_default" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th width="5%" class="text-center">No.</th>
					<th>Kode</th>
					<th>Nama Barang</th>
					<th>Kategori</th>
					<th>Jumlah Stock</th>
					<th width="10%" class="text-center">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($baranglist)){ $count = 1; foreach($baranglist as $row): ?>
				<tr>
					<td class="text-center"><?=$count++; ?></td>
					<td><?=$row['kode']; ?></td>
					<td><?=$row['nama']; ?></td>
					<td><?=$row['nama_kategori']; ?></td>
					<td><?=$row['stock'] .' '. $row['nama_unit']; ?></td>
					<td class="text-center">
						<?php if (get_permission('data_barang', 'is_edit')): ?>
						<a class="btn btn-default btn-circle edit_modal" href="javascript:void(0);"
							data-id="<?=$row['id'];?>">
							<i class="fas fa-pen-nib"></i> Edit
						</a>
						<?php endif; if (get_permission('data_barang', 'is_delete')): ?>
						<?=btn_delete('gudang/submit_barang/delete/' . $row['id']); ?>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; }?>
			</tbody>
		</table>
	</div>
</section>

<?php if(get_permission('data_barang', 'is_add')){ ?>
<div id="add_modal" class="zoom-anim-dialog modal-block modal-block-lg mfp-hide">
	<section class="panel">
		<?php echo form_open(base_url('gudang/submit_barang/save'), array('class' => 'form-horizontal')); ?>
		<div class="panel-heading">
			<h4 class="panel-title">
				<i class="fas fa-bars"></i> Tambah Barang
			</h4>
		</div>

		<div class="panel-body">
			<div class="form-group">
				<label class="col-md-3 control-label">Nama Barang <span class="required">*</span></label>
				<div class="col-md-8">
					<input type="text" class="form-control" name="nama" value="" required />
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Kode Barang <span class="required">*</span></label>
				<div class="col-md-8">
					<input type="text" class="form-control" name="kode" value="<?=$this->app_lib->get_kode('barang'); ?>" required />
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Kategori <span class="required">*</span></label>
				<div class="col-md-8">
					<?php
					echo form_dropdown("kategori", $kategorilist, set_value("kategori"), "class='form-control' data-plugin-selectTwo required
					data-width='100%' data-minimum-results-for-search='Infinity' ");
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Unit <span class="required">*</span></label>
				<div class="col-md-8">
					<?php
					echo form_dropdown("unit", $unitlist, set_value("unit"), "class='form-control' data-plugin-selectTwo required
					data-width='100%' data-minimum-results-for-search='Infinity' ");
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Stock Minimal <span class="required">*</span></label>
				<div class="col-md-8">
					<input type="number" class="form-control" name="stock_min" value="0" required />
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Keterangan</label>
				<div class="col-md-8 mb-lg">
					<input type="text" class="form-control" name="keterangan" value="" />
				</div>
			</div>
		</div>
		<footer class="panel-footer">
			<div class="text-right">
				<button type="submit" class="btn btn-default">Simpan</button>
				<button class="btn btn-default modal-dismiss">Batal</button>
			</div>
		</footer>
		<?php echo form_close();?>
	</section>
</div>
<?php } ?>

<div class="zoom-anim-dialog modal-block modal-block-lg mfp-hide" id="modal">
	<section class="panel">
		<?php
		echo form_open_multipart(base_url(''), array(
			'id' => 'modalfrom',
			'class' => 'form-horizontal validate',
			'method' => 'post'
		));
		?>
		<input type="hidden" name="barang_id" id="barang_id" value="">
		<div class="panel-heading">
			<h4 class="panel-title">
				<i class="fas fa-bars"></i> Edit Barang
			</h4>
		</div>

		<div class="panel-body">
			<div class="form-group">
				<label class="col-md-3 control-label">Nama Barang <span class="required">*</span></label>
				<div class="col-md-8">
					<input type="text" class="form-control" name="nama" id="nama" value="" required />
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Kode Barang <span class="required">*</span></label>
				<div class="col-md-8">
					<input type="text" class="form-control" name="kode" id="kode" value="" required />
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Kategori <span class="required">*</span></label>
				<div class="col-md-8">
					<?php
					echo form_dropdown("kategori", $kategorilist, set_value("kategori"), "class='form-control kategori' required");
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Unit <span class="required">*</span></label>
				<div class="col-md-8">
					<?php
						echo form_dropdown("unit", $unitlist, set_value("unit"), "class='form-control unit' required");
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Stock Minimal <span class="required">*</span></label>
				<div class="col-md-8">
					<input type="number" class="form-control" name="stock_min" id="stock_min" value="" required />
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Keterangan</label>
				<div class="col-md-8 mb-lg">
					<input type="text" class="form-control" name="keterangan" id="keterangan" value="" />
				</div>
			</div>
		</div>

		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<button type="submit" class="btn btn-default">Update</button>
					<button class="btn btn-default modal-dismiss">Batal</button>
				</div>
			</div>
		</footer>
		<?php echo form_close();?>
	</section>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		<?php echo ($this->session->flashdata('form_modal') ? "mfp_modal('#add_modal');" : ''); ?>
		$(document).on('click', '.add_barang', function () {
			mfp_modal('#add_modal');
		});

		$(document).on('click', '.edit_modal', function () {
			var id = $(this).data('id');
			$.ajax({
				url: "<?=base_url('gudang/get_barang')?>",
				type: 'POST',
				data: {id: id},
				dataType: 'json',
				success: function (res) {
					$('#nama').val(res.nama);
					$('#kode').val(res.kode);
					$('#stock_min').val(res.stock_min);
					$('#keterangan').val(res.keterangan);
					$('#barang_id').val(res.id);
					$('.kategori').val(res.kategori_id);
					$('.unit').val(res.unit_id);
					
					$('#modalfrom').attr('action', '<?php echo base_url("gudang/submit_barang/save/");?>' + res.id); 
					mfp_modal('#modal');
				}
			});
		});
	});
</script>
