<header class="panel-heading">
    <h4 class="panel-title">
        <i class="fas fa-list-ul"></i> Edit Data
    </h4>
</header>

<?php echo form_open('poc/proses/simpan'); ?>
<input type="hidden" name="id" value="<?=$po['id'];?>">
<div class="panel-body">
    <div class="form-group">
				<label class="col-md-4 control-label">Nama P.O <span class="required">*</span></label>
				<div class="col-md-7">
                <?php
					$po_list = $this->app_lib->getPo();
					echo form_dropdown("po_id", $po_list, set_value('po_id',$po['po_id']), "class='form-control'
					data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' required");
				?>
					<span class="error"></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Layanan <span class="required">*</span></label>
				<div class="col-md-7">
                <?php
				$array = array(
					"Service" => "Service",
					"Non Service" => "Non Service"
				);
				echo form_dropdown("layanan", $array, set_value('layanan',$po['layanan']), "class='form-control' data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' required");
				?>
					<span class="error"></span>
				</div>
			</div>
    <div class="form-group">
        <label class="col-md-4 control-label">Nomor Bodi <span class="required">*</span></label>
        <div class="col-md-7">
            <input type="text" class="form-control" name="no_bodi" value="<?php echo set_value('no_bodi', $po['no_bodi']); ?>"
                required />
            <span class="error"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label">Nama Sopir <span class="required">*</span></label>
        <div class="col-md-7">
            <input type="text" class="form-control" name="nama_sopir" value="<?php echo set_value('nama_sopir', $po['nama_sopir']); ?>"
                required />
            <span class="error"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label">Jml Penumpang <span class="required">*</span></label>
        <div class="col-md-7">
            <input type="number" class="form-control" name="jml_pnp" value="<?php echo set_value('jml_pnp', $po['jml_pnp']); ?>"
                required />
            <span class="error"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label">Kedatangan <span class="required">*</span></label>
        <div class="col-md-7">
            <?php
				$array = array(
					"Barat" => "Barat",
					"Timur" => "Timur"
				);
				echo form_dropdown("kedatangan", $array, set_value('kedatangan', $po['kedatangan']), "class='form-control' data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity'");
				?>
            <span class="error"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label">Dari <span class="required">*</span></label>
        <div class="col-md-7">
            <input type="text" class="form-control" name="dari" value="<?php echo set_value('dari', $po['dari']); ?>" required />
            <span class="error"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label">Tujuan <span class="required">*</span></label>
        <div class="col-md-7">
            <input type="text" class="form-control" name="tujuan" value="<?php echo set_value('tujuan', $po['tujuan']); ?>" required />
            <span class="error"></span>
        </div>
    </div>
</div>
<footer class="panel-footer">
    <div class="text-right">
        <button type="submit" name="submit" value="1" class="btn btn-default">Update</button>
        <button class="btn btn-default modal-dismiss">Batal</button>
    </div>
</footer>
<?php echo form_close(); ?>