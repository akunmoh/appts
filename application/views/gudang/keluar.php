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
        <?php if(get_permission('barang_keluar', 'is_add')){ ?>
        <div class="panel-btn">
            <a href="javascript:void(0);" class="add_barang btn btn-default btn-circle">
                <i class="fas fa-plus-circle"></i> Tambah Barang Keluar
            </a>
        </div>
        <?php } ?>
        <h4 class="panel-title"><i class="fas fa-list-ul"></i> Data Barang Keluar</h4>
    </header>
    <div class="panel-body">
        <div class="export_title">Laporan Data Barang Keluar</div>
        <table class="table table-bordered table-hover table-condensed table_default" cellspacing="0" width="100%">
            <thead>
                <tr>
					<th width="10%" class="text-center">No. Nota</th>
					<th>Nama Lokasi</th>
					<th>Tanggal Keluar</th>
					<th>Total (Qty)</th>
					<th>Keterangan</th>
					<th width="12%" class="text-center">Aksi</th>
				</tr>
            </thead>
            <tbody>
                <?php if (!empty($keluarlist)){ foreach ($keluarlist as $row): ?>	
				<tr>
					<td lass="text-center"><?=$row['no_nota']; ?></td>
					<td><?=$row['nama_lokasi']; ?></td>
					<td><?=date_indo($row['tanggal']); ?></td>
					<td><?=$row['total']; ?></td>
					<td><?=$row['keterangan']; ?></td>
					<td class="text-center">
						<a href="<?=base_url('gudang/keluar_detail/' . $row['id'] . "/" . $row['hash']); ?>" class="btn btn-circle icon btn-default" data-toggle="tooltip" data-original-title="Lihat Detail"> <i class="fas fa-eye"></i></a>
						<?php if (get_permission('barang_keluar', 'is_edit')): ?>
                        <a href="javascript:void(0);" class="btn btn-circle btn-default icon" data-toggle="tooltip"
                            data-original-title="Edit" onclick="EditKeluar('<?=$row['id']?>');"><i class="fas fa-pen-nib"></i></a>
						<?php endif; if (get_permission('barang_keluar', 'is_delete')): ?>
						<?=btn_delete('gudang/keluar_delete/' . $row['id']); ?>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; }?>
            </tbody>
        </table>
    </div>
</section>

<?php if(get_permission('barang_keluar', 'is_add')){ ?>
<div id="add_modal" class="zoom-anim-dialog modal-block modal-block-lg mfp-hide">
    <section class="panel">
        <?=form_open('gudang/barangkeluar_save', array('id' => 'frmSubmit', 'class' => 'form-horizontal')); ?>
        <div class="panel-heading">
            <h4 class="panel-title">
                <i class="fas fa-bars"></i> Tambah Barang Keluar
            </h4>
        </div>

        <div class="panel-body">
            <div class="form-group">
                <label class="col-md-3 control-label">Lokasi Tujuan <span class="required">*</span></label>
                <div class="col-md-8">
                    <?=form_dropdown("lokasi_id", $lokasilist, set_value("lokasi_id"), "class='form-control' data-plugin-selectTwo id='lokasi_id'
									data-width='100%' ");
						?>
                    <span class="error"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">No. Nota <span class="required">*</span></label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="no_nota"
                        value="<?=$this->app_lib->get_nota_no('barang_keluar'); ?>" id="no_nota" />
                    <span class="error"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Tanggal <span class="required">*</span></label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="tanggal" value="<?=date('Y-m-d'); ?>"
                        data-plugin-datepicker data-plugin-options='{ "todayHighlight" : true }' id='tanggal' />
                    <span class="error"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Keterangan</label>
                <div class="col-md-8 mb-lg">
                    <textarea class="form-control" rows="2" name="keterangan"></textarea>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="tableID">
                    <thead>
                        <th>Nama Barang <span class="required">*</span></th>
                        <th>Jumlah <span class="required">*</span></th>
                    </thead>
                    <tbody>
                        <tr id="row_0">
                            <td width="70%">
                                <select data-plugin-selectTwo class="form-control barang_keluar" data-width="100%"
                                    name="barangkeluar[0][barang]" id="barang0">
                                    <option value="">Pilih Barang</option>
                                    <?php foreach ($baranglist as $value) { ?>
                                    <option value="<?=$value['id']; ?>">
                                        <?=$value['nama'] . ' (Stock:'. $value['stock'] . ')'?>
                                    </option>
                                    <?php } ?>
                                </select>
                                <span class="error"></span>
                            </td>
                            <td width="30%">
                                <input type="text" class="form-control qty_barang"
                                    name="barangkeluar[0][jumlah]" value="0" id="quantity0" />
                                <span class="error"></span>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>
                                <table width="100%">
                                    <tr>
                                        <td><button type="button" class="btn btn-default" onclick="addRows()"><i class="fas fa-plus-circle"></i> Tambah</button></td>
                                        <td class="text-right"><b>Total :</b></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <input type="text" id="netQTYTotal" class="text-right form-control"
                                    name="net_grand_total" value="0" readonly />
                                <input type="hidden" id="totalQTY" name="qty_total" value="0">
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <footer class="panel-footer">
            <div class="text-right">
            <button type="submit" name="submit" id="savebtn" value="1" class="btn btn-default" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
									<i class="fas fa-save"></i> Simpan
								</button>
                <button class="btn btn-default modal-dismiss">Batal</button>
            </div>
        </footer>
        <?=form_close();?>
    </section>
</div>
<?php } ?>

<div class="zoom-anim-dialog modal-block modal-block-lg mfp-hide" id="EditKeluar">
    <section class="panel" id='view'></section>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		<?=($this->session->flashdata('form_modal') ? "mfp_modal('#add_modal');" : ''); ?>
		$(document).on('click', '.add_barang', function () {
			mfp_modal('#add_modal');
		});
	});
</script>

<script type="text/javascript">
	var count = 1;
	$(document).ready(function() {
		$(document).on('change', '.barang_keluar', function() {
			var row = $(this).closest('tr');
			var id = $(this).val();
			$.ajax({
				type: "POST",
				data: {'id' : id},
				url: "<?=base_url('ajax/get_harga_barang'); ?>",
				success: function (result) {
					var unit_price = read_number(result);
					var quantity = read_number(row.find('.qty_barang').val());
					var total_price = unit_price * quantity;
					row.find('.barangkeluar_unit_price').val(unit_price.toFixed(0));
					var after_discount = total_price;
					row.find('.sub_total').val(total_price.toFixed(0));
					row.find('.net_sub_total').val(after_discount.toFixed(0));
					grandTotalCalculatePur();
				}
			});
		});

		$(document).on('change keyup', '.qty_barang', function() {
			var row = $(this).closest('tr');
			var quantity = read_number(row.find('.qty_barang').val());
			var unit_price = read_number(row.find('.barangkeluar_unit_price').val());
			var total_price = unit_price * quantity;
			var after_discount = total_price;
			row.find('.sub_total').val(total_price.toFixed(0));
			row.find('.net_sub_total').val(after_discount.toFixed(0));
			grandTotalCalculatePur();
		});
	});

	function addRows(){
		var tbody = $('#tableID').children('tbody');
		tbody.append(getDynamicInput(count));
		$("#barang" + count).select2({
		    theme: "bootstrap",
		    width: "100%"
		});
		count++;
	}

    function deleteRow(id) {
        $("#row_" + id).remove();
        grandTotalCalculatePur();
    }

	function getDynamicInput(value) {
		var html_row = "";
		html_row += '<tr id="row_' + value + '">';
		html_row += '<td>';
		html_row += '<select id="barang' + value + '" name="barangkeluar[' + value + '][barang]" class="form-control barang_keluar" >';
		html_row += '<option value="">Pilih Barang</option>';
		<?php foreach ($baranglist as $barang): ?>
		html_row += '<option value="<?=$barang['id'];?>" ><?=$barang['nama']. ' (Stock: ' . $barang['stock'] . ')'; ?></option>';
		<?php endforeach; ?>
		html_row += '</select>';
		html_row += '<span class="error"></span></div></td>';
		html_row += '</td>';
		html_row += '<td class="min-w-md">';
		html_row += '<input type="number" class="form-control qty_barang" name="barangkeluar[' + value + '][jumlah]" id="quantity' + value + '" value="0" style="float: left; width: 70%;" />';
		html_row += '<button type="button" class="btn btn-danger" onclick="deleteRow(' + value + ')" style="float: right; max-width: 30%"><i class="fas fa-times"></i> </button>';
		html_row += '</td>';
		html_row += '</tr>';
		return html_row;
	}
</script>