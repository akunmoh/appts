<header class="panel-heading">
	<h4 class="panel-title">
		<i class="fas fa-list-ul"></i> Edit Barang Masuk
	</h4>
</header>

<?=form_open('gudang/keluar_edit_save', array('id' => 'frmSubmit', 'class' => 'form-horizontal')); ?>
<input type="hidden" name="barangkeluar_id" value="<?php echo $barangkeluarlist['id']; ?>">
<div class="panel-body">
	<div class="form-group">
		<label class="col-md-3 control-label">Lokasi Tujuan <span class="required">*</span></label>
		<div class="col-md-8">
			<?php
			echo form_dropdown("lokasi_id", $lokasilist, $barangkeluarlist['lokasi_id'], "class='form-control' data-plugin-selectTwo id='lokasi_id' data-width='100%' ");
			?>
			<span class="error"></span>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label">No. Nota <span class="required">*</span></label>
		<div class="col-md-8">
			<input type="text" class="form-control" name="no_nota" id='no_nota'
				value="<?php echo $barangkeluarlist['no_nota']; ?>" />
			<span class="error"></span>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label">Tanggal <span class="required">*</span></label>
		<div class="col-md-8">
			<input type="text" class="form-control" name="tanggal" id='tanggal'
				value="<?php echo $barangkeluarlist['tanggal']; ?>" data-plugin-datepicker
				data-plugin-options='{ "todayHighlight" : true }' />
			<span class="error"></span>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label">Keterangan</label>
		<div class="col-md-8 mb-lg">
			<textarea class="form-control" rows="2"
				name="keterangan"><?php echo $barangkeluarlist['keterangan']; ?></textarea>
		</div>
	</div>

	<div class="table-responsive">
		<table class="table table-bordered" id="tableID">
			<thead>
				<th>Nama Barang <span class="required">*</span></th>
				<th>Jumlah <span class="required">*</span></th>
			</thead>
			<tbody>
				<?php
				$count = 1;
				$this->db->order_by('id', 'ASC');
				$keluar_details = $this->db->get_where('barang_keluar_detail', array('barangkeluar_id' => $barangkeluarlist['id']))->result();
				if(count($keluar_details)){
					foreach ($keluar_details as $key => $barang):
				?>
				<tr>
					<td width="70%">
						<input type="hidden" name="barangkeluar[<?php echo $key; ?>][old_keluar_details_id]"
							value="<?php echo $barang->id; ?>">
						<input type="hidden" name="barangkeluar[<?php echo $key; ?>][old_barang_id]"
							value="<?php echo $barang->barang_id; ?>">
						<input type="hidden" name="barangkeluar[<?php echo $key; ?>][old_jumlah]"
							value="<?php echo $barang->jumlah; ?>">
						<select data-plugin-selectTwo class="form-control barang_keluar" data-width="100%"
							name="barangkeluar[<?php echo $key; ?>][barang]" id="barang<?php echo $key; ?>">
							<option value="">Pilih</option>
							<?php foreach ($baranglist as $value) { ?>
							<option value="<?php echo $value['id']; ?>"
								<?php echo ($value['id'] == $barang->barang_id ? 'selected' : ''); ?>>
								<?php echo $value['nama']. ' (Stock: '. $value['stock'] . ')'; ?></option>
							<?php } ?>
						</select>
						<span class="error"></span>
					</td>
					<td width="30%">
						<input type="text" class="form-control qty_barang"
							name="barangkeluar[<?php echo $key; ?>][jumlah]" id="quantity<?php echo $key; ?>"
							value="<?php echo $barang->jumlah; ?>" />
						<input type="hidden" name="old_barangkeluar[<?php echo $key; ?>][jumlah]"
							value="<?php echo $barang->jumlah; ?>">
						<span class="error"></span>
					</td>
				</tr>
				<?php endforeach; } ?>
			</tbody>
			<tfoot>
				<tr>
					<td>
						<table width="100%">
							<tr>
								<td><button type="button" class="btn btn-default" onclick="addRows()"><i
											class="fas fa-plus-circle"></i> Tambah</button></td>
								<td class="text-right"><b>Total :</b></td>
							</tr>
						</table>
					</td>
					<td>
						<input type="text" id="netQTYTotal" class="text-right form-control" name="net_grand_total"
							value="<?php echo $barangkeluarlist['total']; ?>" readonly />
						<input type="hidden" id="totalQTY" name="qty_total" value="<?php echo $barangkeluarlist['total']; ?>">
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<footer class="panel-footer">
    <div class="text-right">
    	<button type="submit" name="submit" id="savebtn" value="1" class="btn btn-default" 
			data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
			<i class="fas fa-save"></i> Update
		</button>
        <button class="btn btn-default modal-dismiss">Batal</button>
    </div>
</footer>
<?php echo form_close(); ?>
