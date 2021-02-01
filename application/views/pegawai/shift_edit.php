<header class="panel-heading">
    <h4 class="panel-title">
        <i class="fas fa-list-ul"></i> Edit Shift Pegawai
    </h4>
</header>

<?php echo form_open('pegawai/shift_edit_post'); ?>
<input type="hidden" name="id" value="<?=$shift['id']; ?>">
<div class="panel-body">
    <div class="form-group <?php if (form_error('nama')) echo 'has-error'; ?>">
        <label class="col-md-3 control-label">Nama Shift <span class="required">*</span></label>
        <div class="col-md-8">
            <input type="text" class="form-control" name="nama" value="<?=set_value('nama', $shift['nama']); ?>" />
            <span class="error"><?php echo form_error('nama'); ?></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Jam Masuk <span class="required">*</span></label>
        <div class="col-md-8">
            <div class="input-group">
                <span class="input-group-addon"><i class="far fa-clock"></i></span>
                <input type="text" name="jam_masuk" value="<?=set_value('jam_masuk', $shift['jam_masuk']); ?>" class="form-control timepicker" />
            </div>
            <span class="error"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Jam Keluar <span class="required">*</span></label>
        <div class="col-md-8">
            <div class="input-group">
                <span class="input-group-addon"><i class="far fa-clock"></i></span>
                <input type="text" name="jam_keluar" value="<?=set_value('jam_keluar', $shift['jam_keluar']); ?>" class="form-control timepicker" />
            </div>
            <span class="error"></span>
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
    $(function () {
        $('.timepicker').timepicker({
            showMeridian: false
        });
    });
</script>