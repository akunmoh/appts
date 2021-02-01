<header class="panel-heading">
    <h4 class="panel-title">
        <i class="fas fa-list-ul"></i> Edit Kas Masuk
    </h4>
</header>

<?php echo form_open('kas/aksi_pemasukkan/simpan'); ?>
<input type="hidden" name="id" value="<?=$pemasukkan['id'];?>">
<input type="hidden" name="kode" value="<?=$pemasukkan['kode'];?>">
<input type="hidden" name="old_nominal" value="<?=$pemasukkan['nominal']; ?>">
<div class="panel-body">
    <div class="form-group">
        <label class="col-md-4 control-label">Sumber Pemasukkan <span class="required">*</span></label>
        <div class="col-md-7">
            <?php
				echo form_dropdown("sumber_id", $sumberlist, set_value('sumber_id',$pemasukkan['sumber_id']), "class='form-control' required data-plugin-selectTwo
				data-width='100%' data-minimum-results-for-search='Infinity'");
			?>
            <span class="error"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label">Nama Pemasukkan <span class="required">*</span></label>
        <div class="col-md-7">
            <input type="text" class="form-control" name="nama" value="<?php echo set_value('nama',$pemasukkan['nama']); ?>" required />
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label">Nominal<span class="required">*</span></label>
        <div class="col-md-7">
            <input type="text" class="form-control" name="nominal" id="nominal"
                value="<?php echo set_value('nominal',$pemasukkan['nominal']); ?>" required />
            <span class="error"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label">Tanggal <span class="required">*</span></label>
        <div class="col-md-7">
            <input type="text" class="form-control" name="tanggal"
                value="<?php echo set_value('tanggal', $pemasukkan['tanggal']); ?>" data-plugin-datepicker autocomplete="off"
                data-plugin-options='{ "todayHighlight" : true, "endDate": "+0d" }' />
            <span class="error"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label">Keterangan</label>
        <div class="col-md-7">
            <textarea class="form-control" name="keterangan" placeholder="" rows="3"><?=$pemasukkan['keterangan'];?></textarea>
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