<section class="panel">
    <header class="panel-heading">
        <div class="panel-btn">
            <a href="javascript:void(0);" class="add_sumber btn btn-default btn-circle icon"><i class="fas fa-plus"></i>
                Tambah Sumber </a>
        </div>
        <h4 class="panel-title"><i class="fas fa-list-ul"></i> Data Sumber Pengeluaran</h4>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-hover table-condensed table_default" cellspacing="0" width="100%" id="table-export">
            <thead>
                <tr>
                    <th width="5%" class="text-center">No.</th>
                    <th>Sumber Pengeluaran</th>
                    <th width="10%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
				$count = 1;
				if (!empty($pengeluaranlist)){
				    foreach ($pengeluaranlist as $row):
				?>
                <tr>
                    <td class="text-center"><?=$count++; ?></td>
                    <td><?=$row['nama']; ?></td>
                    <td class="text-center">
                        <?php if (get_permission('sumber_kas_keluar', 'is_edit')): ?>
                        <a href="javascript:void(0);" class="btn btn-circle btn-default icon" data-toggle="tooltip"
                            data-original-title="Edit" onclick="EditSumber2('<?=$row['id']?>');"><i class="fas fa-pen-nib"></i></a>
                        <?php endif; if (get_permission('sumber_kas_keluar', 'is_delete')): ?>
                        <?=btn_delete('kas/sumber_pengeluaran_delete/' . $row['id']); ?>
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

<div id="add_sumber" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
    <section class="panel">
        <div class="panel-heading">
            <h4 class="panel-title">
                <i class="far fa-plus-square"></i> Tambah Sumber Pengeluaran
            </h4>
        </div>
        <?php echo form_open($this->uri->uri_string(), array('class' => 'form-horizontal')); ?>
        <div class="panel-body">
            <div class="form-group <?php if (form_error('nama')) echo 'has-error'; ?>">
                <label class="col-md-4 control-label">Sumber Pengeluaran <span class="required">*</span></label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="nama" value="<?php echo set_value('nama'); ?>" />
                    <span class="error"><?php echo form_error('nama'); ?></span>
                </div>
            </div>
        </div>
        <footer class="panel-footer">
            <div class="text-right">
                <button type="submit" name="submit" value="pengeluaran" class="btn btn-default">Simpan</button>
                <button class="btn btn-default modal-dismiss">Batal</button>
            </div>
        </footer>
        <?php echo form_close();?>
    </section>
</div>

<div class="zoom-anim-dialog modal-block modal-block-primary mfp-hide" id="EditSumber2">
	<section class="panel" id='view'></section>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		<?php echo ($this->session->flashdata('form_modal') ? "mfp_modal('#add_sumber');" : ''); ?>
        $(document).on('click', '.add_sumber', function () {
			mfp_modal('#add_sumber');
		});
	});
</script>