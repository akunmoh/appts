<section class="panel">
	<header class="panel-heading">
		<h4 class="panel-title"><i class="fas fa-search"></i> Filter Data</h4>
	</header>
	<?=form_open($this->uri->uri_string(), array('class' => 'validate')); ?>
	<div class="panel-body">
		<div class="row mb-sm">
			<div class="col-md-offset-4 col-md-4 mb-sm">
				<div class="form-group <?php if (form_error('tanggal')) echo 'has-error'; ?>">
					<label class="control-label">Tanggal <span class="required">*</span></label>
					<div class="input-group">
						<input type="text" class="form-control" data-plugin-datepicker name="tanggal"
							value="<?=set_value('tanggal', date("Y-m-d"))?>" />
						<span class="input-group-addon"><i class="icon-event icons"></i></span>
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
		<?php if(get_permission('barang_masuk', 'is_add')){ ?>
		<div class="panel-btn">
			<a href="javascript:void(0);" class="add_barang btn btn-default btn-circle">
			<i class="fas fa-plus-circle"></i> Tambah Barang Masuk
			</a>
		</div>
		<?php } ?>
		<h4 class="panel-title"><i class="fas fa-list-ul"></i> Data Barang Masuk</h4>
	</header>
	<div class="panel-body">
		<div class="export_title">Laporan Data Barang Masuk</div>
		<table class="table table-bordered table-hover table-condensed table_default" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th width="5%" class="text-center">No.</th>
					<th>Kategori</th>
					<th>Nama Barang</th>
					<th>Tambah Stok</th>
					<th>Tanggal</th>
					<th>Ditambah Oleh</th>
					<th width="10%" class="text-center">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$count = 1;
				if(!empty($stocklist)) {
					foreach ($stocklist as $row):
				?>
				<tr>
					<td class="text-center"><?php echo $count++; ?></td>
					<td><?php echo html_escape($row['nama_kategori']); ?></td>
					<td><?php echo html_escape($row['nama_barang']); ?></td>
					<td><?php echo html_escape($row['stock_qty']); ?></td>
					<td><?php echo html_escape(date_indo($row['tanggal'])); ?></td>
					<td><?php echo html_escape($row['nama_staff']); ?></td>
					<td class="text-center">
						<?php if (get_permission('barang_masuk', 'is_edit')): ?>
						<a href="javascript:void(0);" class="btn btn-circle btn-default icon" data-toggle="tooltip"
                            data-original-title="Edit" onclick="EditMasuk('<?=$row['id']?>');"><i class="fas fa-pen-nib"></i></a>
						<?php endif; if (get_permission('barang_masuk', 'is_delete')): ?>
						<?=btn_delete('gudang/submit_barangmasuk/delete/' . $row['id']); ?>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; }?>
			</tbody>
		</table>
	</div>
</section>

<?php if(get_permission('barang_masuk', 'is_add')){ ?>
<div id="add_modal" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
	<section class="panel">
		<?php echo form_open(base_url('gudang/submit_barangmasuk/save'), array('class' => 'form-horizontal')); ?>
		<div class="panel-heading">
			<h4 class="panel-title">
				<i class="fas fa-bars"></i> Tambah Barang Masuk
			</h4>
		</div>

		<div class="panel-body">
			<div class="form-group">
				<label class="col-md-3 control-label">Kategori Barang <span class="required">*</span></label>
				<div class="col-md-8">
					<?php
						echo form_dropdown("kategori_id", $kategorilist, set_value("kategori_id"), "class='form-control' data-plugin-selectTwo
						onchange='getBarangByKategori(this.value,0)' required data-width='100%' ");
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Nama Barang <span class="required">*</span></label>
				<div class="col-md-8">
					<select name="barang_id" class="form-control" data-plugin-selectTwo data-width="100%" id="barang_id"
						required>
						<option value="">Pilih</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Tanggal <span class="required">*</span></label>
				<div class="col-md-8">
					<input type="text" class="form-control" data-plugin-datepicker
						data-plugin-options='{"todayHighlight" : true}' name="tanggal"
						value="<?php echo date('Y-m-d'); ?>" required />
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Jumlah Stock <span class="required">*</span></label>
				<div class="col-md-8">
					<input type="number" class="form-control" name="stock_qty" value="0" required />
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Keterangan</label>
				<div class="col-md-8 mb-lg">
					<textarea class="form-control" id="keterangan" name="keterangan" placeholder="" rows="3"></textarea>
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

<div class="zoom-anim-dialog modal-block modal-block-primary mfp-hide" id="EditMasuk">
	<section class="panel" id='view'></section>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		<?php echo ($this->session->flashdata('form_modal') ? "mfp_modal('#add_modal');" : ''); ?>
		$(document).on('click', '.add_barang', function () {
			mfp_modal('#add_modal');
		});
	});
</script>