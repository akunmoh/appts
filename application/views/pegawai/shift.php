<section class="panel">
    <header class="panel-heading">
        <div class="panel-btn">
            <a href="javascript:void(0);" class="add_shift btn btn-default btn-circle icon"><i class="fas fa-plus"></i>
                Tambah Shift </a>
        </div>
        <h4 class="panel-title"><i class="fas fa-retweet"></i> Shift Pegawai</h4>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-hover table-condensed table_default" cellspacing="0" width="100%"
            id="table-export">
            <thead>
                <tr>
                    <th width="5%" class="text-center">No.</th>
                    <th>Nama Shift</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th width="10%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
				$count = 1;
				if (!empty($shiftlist)){
				    foreach ($shiftlist as $row):
				?>
                <tr>
                    <td class="text-center"><?=$count++; ?></td>
                    <td><?=$row['nama']; ?></td>
                    <td><?=$row['jam_masuk']; ?></td>
                    <td><?=$row['jam_keluar']; ?></td>
                    <td class="text-center">
                        <?php if (get_permission('shift_pegawai', 'is_edit')): ?>
                        <a href="javascript:void(0);" class="btn btn-circle btn-default icon" data-toggle="tooltip"
                            data-original-title="Edit" onclick="EditShift('<?=$row['id']?>');"><i
                                class="fas fa-pen-nib"></i></a>
                        <?php endif; if (get_permission('shift_pegawai', 'is_delete')): ?>
                        <?=btn_delete('pegawai/shift_delete/' . $row['id']); ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php
					endforeach;
				}else{
					echo '<tr><td colspan="3"><h5 class="text-danger text-center">Data masih kosong</td></tr>';
				}
				?>
            </tbody>
            </tbody>
        </table>
    </div>
</section>

<div id="add_shift" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
    <section class="panel">
        <div class="panel-heading">
            <h4 class="panel-title">
                <i class="far fa-plus-square"></i> Tambah Shift
            </h4>
        </div>
        <?php echo form_open($this->uri->uri_string(), array('class' => 'form-horizontal')); ?>
        <div class="panel-body">
            <div class="form-group <?php if (form_error('nama')) echo 'has-error'; ?>">
                <label class="col-md-3 control-label">Nama Shift <span class="required">*</span></label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="nama" value="<?php echo set_value('nama'); ?>" />
                    <span class="error"><?php echo form_error('nama'); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Jam Masuk <span class="required">*</span></label>
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="far fa-clock"></i></span>
                        <input type="text" name="jam_masuk" class="form-control timepicker" />
                    </div>
                    <span class="error"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">Jam Keluar <span class="required">*</span></label>
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="far fa-clock"></i></span>
                        <input type="text" name="jam_keluar" class="form-control timepicker" />
                    </div>
                    <span class="error"></span>
                </div>
            </div>
        </div>

        <footer class="panel-footer">
            <div class="text-right">
                <button type="submit" name="submit" value="shift" class="btn btn-default">Simpan</button>
                <button class="btn btn-default modal-dismiss">Batal</button>
            </div>
        </footer>
        <?php echo form_close();?>
    </section>
</div>

<div class="zoom-anim-dialog modal-block modal-block-primary mfp-hide" id="EditShift">
    <section class="panel" id='view'></section>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		<?php echo ($this->session->flashdata('form_modal') ? "mfp_modal('#add_shift');" : ''); ?>
        $(document).on('click', '.add_shift', function () {
			mfp_modal('#add_shift');
		});
    });
    $(function () {
        $('.timepicker').timepicker({
            showMeridian: false
        });
    });
</script>