<header class="panel-heading">
    <h4 class="panel-title">
        <i class="fas fa-list-ul"></i> Pembayaran Gaji
    </h4>
    <div class="panel-btn">
        <button class="btn btn-default btn-sm modal-dismiss"><i class="fas fa-times"></i></button>
	</div>
</header>

<?php echo form_open('penggajian/simpan_gaji'); ?>
<input type="hidden" name="id" value="<?=$gaji['id'];?>">
<div class="panel-body">
    <div class="form-group">
        <label class="col-md-4 control-label">Nama Pegawai <span class="required">*</span></label>
        <div class="col-md-7">
            <input type="text" class="form-control" name="nama" value="<?php echo set_value('nama',$gaji['nama_pegawai']); ?>" readonly />
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label">Total Gaji<span class="required">*</span></label>
        <div class="col-md-7">
            <input type="text" class="form-control" name="total_gaji"
                value="<?php echo set_value('total_gaji',number_format($gaji['total_gaji'], 0, '.', ',')); ?>" readonly />
            <span class="error"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label">Gaji Bulan<span class="required">*</span></label>
        <div class="col-md-7">
            <input type="text" class="form-control" name="gaji_bulan"
                value="<?php echo set_value('gaji_bulan',bulan($gaji['bulan']).'-'.$gaji['tahun']); ?>" readonly />
            <span class="error"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label">Tanggal Gajian<span class="required">*</span></label>
        <div class="col-md-7">
            <input type="text" class="form-control" name="tanggal"
                value="<?php echo set_value('tanggal', $gaji['tanggal']); ?>" data-plugin-datepicker autocomplete="off"
                data-plugin-options='{ "todayHighlight" : true, "endDate": "+0d" }' />
            <span class="error"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 control-label">Keterangan</label>
        <div class="col-md-7">
            <textarea class="form-control" name="keterangan" placeholder="" rows="3"><?=$gaji['keterangan'];?></textarea>
        </div>
    </div>
</div>
<input type="hidden" name="pegawai_id" value="<?=$gaji['pegawai_id'];?>">
<input type="hidden" name="kode" value="<?=$gaji['kode'];?>">
<input type="hidden" name="nominal" value="<?=$gaji['total_gaji'];?>">
<footer class="panel-footer">
    <div class="text-right">
        <button type="submit" name="submit" value="1" class="btn btn-default">Bayar</button>
    </div>
</footer>
<?php echo form_close(); ?>