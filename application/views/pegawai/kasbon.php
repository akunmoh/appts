<section class="panel">
	<header class="panel-heading">
		<?php if(get_permission('kasbon', 'is_add')){ ?>
		<div class="panel-btn">
			<a href="javascript:void(0);" class="add_barang btn btn-default btn-circle">
				<i class="fas fa-plus-circle"></i> Tambah Kasbon
			</a>
		</div>
		<?php } ?>
		<h4 class="panel-title"><i class="fas fa-list-ul"></i> Data Kasbon Pegawai</h4>
	</header>
	<div class="panel-body">
		<div class="export_title">Laporan Data Kasbon Pegawai</div>
		<table class="table table-bordered table-hover table-condensed table_default" cellspacing="0" width="100%">
			<thead>
				<tr>
                    <th>No.</th>
					<th>Nama Pegawai</th>
                    <th>Nominal (Rp)</th>
                    <th>Bulan</th>
                    <th>Keterangan</th>
                    <th>Tanggal</th>
					<th>Staff</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
                <?php $count = 1; if (!empty($kasbon)){ foreach ($kasbon as $row): ?>
				<tr>
					<td><?php echo $count++; ?></td>
					<td><?php echo $row['nama_pegawai']; ?></td>
					<td><?php echo number_format($row['nominal'], 0, '.', ','); ?></td>
					<td><?php echo bulan($row['bulan']); ?></td>
                    <td><?php echo $row['keterangan']; ?></td>
                    <td><?php echo date_indo($row['tanggal']); ?></td>
					<td><?php echo $row['nama_staff']; ?></td>
					<td>
						<?php if (get_permission('kasbon', 'is_delete')): ?>
						<?=btn_delete('pegawai/kasbon_proses/hapus/' . $row['id']); ?>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; }?>
			</tbody>
		</table>
	</div>
</section>

<?php if(get_permission('kasbon', 'is_add')){ ?>
<div id="add_modal" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
	<section class="panel">
		<?php echo form_open_multipart(base_url('pegawai/kasbon_proses/simpan'), array('class' => 'form-horizontal')); ?>
		<div class="panel-heading">
			<h4 class="panel-title">
				<i class="fas fa-bars"></i> Tambah Kasbon
			</h4>
		</div>

		<div class="panel-body">
			<div class="form-group">
				<label class="col-md-4 control-label">Nama Pegawai <span class="required">*</span></label>
				<div class="col-md-7">
					<?php
					echo form_dropdown("pegawai_id", $pegawailist, set_value('pegawai_id'), "class='form-control' required data-plugin-selectTwo
					data-width='100%' data-minimum-results-for-search='Infinity'");
					?>
					<span class="error"></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Nominal<span class="required">*</span></label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="nominal" id="nominal"
						value="<?php echo set_value('nominal'); ?>" required />
					<span class="error"></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Tanggal <span class="required">*</span></label>
				<div class="col-md-7">
                    <input type="text" class="form-control monthyear" name="month_year"
							value="<?php echo set_value('month_year',date("Y-m")); ?>" required />
					<span class="error"></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Keterangan</label>
				<div class="col-md-7">
					<textarea class="form-control" name="keterangan" placeholder="" rows="3"></textarea>
				</div>
			</div>
		</div>
		<footer class="panel-footer">
			<div class="text-right">
				<button type="submit" class="btn btn-default">Simpan</button>
				<button class="btn btn-default modal-dismiss">Batal</button>
			</div>
		</footer>
		<?php echo form_close();?>
	</section>
</div>
<?php } ?>

<div class="zoom-anim-dialog modal-block modal-block-primary mfp-hide" id="KasKeluar">
	<section class="panel" id='view'></section>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		<?php echo ($this->session->flashdata('form_modal') ? "mfp_modal('#add_modal');" : ''); ?>
		$(document).on('click', '.add_barang', function () {
			mfp_modal('#add_modal');
		});
	});
</script>