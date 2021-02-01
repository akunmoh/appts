<header class="panel-heading">
    <h4 class="panel-title">
        <i class="fas fa-list-ul"></i> Edit Lokasi Pegawai
    </h4>
</header>

<?php echo form_open('pegawai/lokasi_edit_post'); ?>
<input type="hidden" name="lokasi_id" value="<?=$lokasi['id']; ?>">
<div class="panel-body">
    <div class="form-group <?php if (form_error('nama')) echo 'has-error'; ?>">
        <label class="col-md-3 control-label">Nama Lokasi <span class="required">*</span></label>
        <div class="col-md-8">
            <input type="text" class="form-control" name="nama" value="<?=set_value('nama', $lokasi['nama']); ?>" />
            <span class="error"><?php echo form_error('nama'); ?></span>
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