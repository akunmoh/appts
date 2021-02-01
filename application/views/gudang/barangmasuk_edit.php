<?php $barang = $this->gudang_model->get_list('barang', array('id' => $stock['barang_id']), true, 'kategori_id'); ?>
<header class="panel-heading">
	<h4 class="panel-title">
		<i class="fas fa-list-ul"></i> Edit Barang Masuk
	</h4>
</header>

<?php echo form_open('gudang/submit_barangmasuk/save'); ?>
<input type="hidden" name="stock_id" value="<?=$stock['id'];?>">
<input type="hidden" name="old_stock_qty" value="<?=$stock['stock_qty']; ?>">
<input type="hidden" name="old_barang_id" value="<?=$stock['barang_id']; ?>">
<div class="panel-body">
	<div class="form-group">
		<label class="col-md-3 control-label">Kategori Barang <span class="required">*</span></label>
		<div class="col-md-8">
		<?php
			echo form_dropdown("kategori_id", $kategorilist, set_value('kategori_id', $barang['kategori_id']), "class='form-control'
			data-plugin-selectTwo onchange='getBarangByKategori(this.value,0)' required data-width='100%' ");
		?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label">Nama Barang <span class="required">*</span></label>
		<div class="col-md-8">
			<?php
			$barang_list = array('' => 'Pilih');
			echo form_dropdown("barang_id", $barang_list, set_value("barang_id"), "class='form-control' data-plugin-selectTwo
			id='barang_id' required data-width='100%' ");
			?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label">Tanggal <span class="required">*</span></label>
		<div class="col-md-8">
			<input type="text" class="form-control" data-plugin-datepicker
				data-plugin-options='{"todayHighlight" : true}' name="tanggal"
				value="<?php echo $stock['tanggal']; ?>" required />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label">Jumlah Stock <span class="required">*</span></label>
		<div class="col-md-8">
			<input type="number" class="form-control" name="stock_qty"
				value="<?php echo $stock['stock_qty']; ?>" required />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label">Keterangan</label>
		<div class="col-md-8 mb-lg">
			<textarea class="form-control" id="keterangan" name="keterangan" placeholder=""
				rows="3"><?php echo $stock['keterangan']; ?></textarea>
		</div>
	</div>
</div>
<footer class="panel-footer">
	<div class="text-right">
		<button type="submit" name="update" value="1" class="btn btn-default">Update</button>
		<button class="btn btn-default modal-dismiss">Batal</button>
	</div>
</footer>
<?php echo form_close(); ?>


<script type="text/javascript">
	$(document).ready(function () {
		var barang_kategori_id = "<?php echo $barang['kategori_id']; ?>";
		var barang_id = "<?php echo $stock['barang_id']; ?>";
		getBarangByKategori(barang_kategori_id, barang_id);
	});
</script>