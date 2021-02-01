<section class="panel">
	<header class="panel-heading">
		<?php if(get_permission('non_sinar_jaya', 'is_add')){ ?>
		<div class="panel-btn">
			<a href="javascript:void(0);" class="add_data btn btn-default btn-circle">
				<i class="fas fa-plus-circle"></i> Tambah Data
			</a>
		</div>
		<?php } ?>
		<h4 class="panel-title"><i class="fas fa-list-ul"></i> Data P.O Stand C</h4>
	</header>
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<?php
			$this->db->where_not_in('id', array(1));
			$po = $this->db->get('po_nama')->result();
			foreach ($po as $d){
			?> 	
			<li class="<?php if ($d->id == $po_id) echo 'active'; ?>">
				<a href="<?php echo base_url('poc/view/'.$d->id); ?>">
					<i class="fas fa-bus"></i>
					<span class="hidden-xs"> <?php echo html_escape($d->nama)?></span>
				</a>
			</li>
			<?php } ?>
		</ul>
		
		<div class="tab-content">
			<div class="tab-pane box active">
				<div class="export_title">Data List</div>
				<table class="table table-bordered table-hover table-condensed" cellspacing="0" width="100%" id="table-export">
					<thead>
						<tr>
							<th>No.</th>
							<th>Layanan</th>
							<th>Nomor Bodi</th>
							<th>Nama Sopir</th>
							<th>Jml Pnp</th>
							<th>Kedatangan</th>
							<th>Dari</th>
							<th>Tujuan</th>
							<th>Tanggal</th>
							<th>Staff</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $count = 1; if (!empty($buslist)){ foreach ($buslist as $row): ?>
						<tr>
							<td class="text-center"><?=$count++; ?></td>
							<td><?php echo $row['layanan']; ?></td>
							<td><?php echo $row['no_bodi']; ?></td>
							<td><?php echo $row['nama_sopir']; ?></td>
							<td><?php echo $row['jml_pnp']; ?></td>
							<td><?php echo $row['kedatangan']; ?></td>
							<td><?php echo $row['dari']; ?></td>
							<td><?php echo $row['tujuan']; ?></td>
							<td><?php echo tgl_indo($row['tanggal']); ?></td>
							<td><?php echo $row['nama_staff']; ?></td>
							<td>
								<?php if (get_permission('non_sinar_jaya', 'is_edit')): ?>
								<a href="javascript:void(0);" class="btn btn-circle btn-default icon" data-toggle="tooltip"
									data-original-title="Edit" onclick="EditData('<?=$row['id']?>','nonsinar');"><i class="fas fa-pen-nib"></i></a>
								<?php endif; if (get_permission('non_sinar_jaya', 'is_delete')): ?>
								<?=btn_delete('poc/proses/hapus/' . $row['id']); ?>
								<?php endif; ?>
							</td>
						</tr>
						<?php endforeach; }?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>

<?php if(get_permission('non_sinar_jaya', 'is_add')){ ?>
<div id="add_modal" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
	<section class="panel">
		<?php echo form_open_multipart(base_url('poc/proses/simpan'), array('class' => 'form-horizontal')); ?>
		<div class="panel-heading">
			<h4 class="panel-title">
				<i class="fas fa-bars"></i> Tambah Data
			</h4>
		</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-md-4 control-label">Nama P.O <span class="required">*</span></label>
				<div class="col-md-7">
                <?php
					$po_list = $this->app_lib->getPo();
					echo form_dropdown("po_id", $po_list, set_value('po_id'), "class='form-control'
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
				echo form_dropdown("layanan", $array, set_value('layanan'), "class='form-control' data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' required");
				?>
					<span class="error"></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Nomor Bodi <span class="required">*</span></label>
				<div class="col-md-7">
                    <input type="text" class="form-control" name="no_bodi" value="<?php echo set_value('no_bodi'); ?>" required />
					<span class="error"></span>
				</div>
			</div>
            <div class="form-group">
				<label class="col-md-4 control-label">Nama Sopir <span class="required">*</span></label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="nama_sopir" value="<?php echo set_value('nama_sopir'); ?>" required />
					<span class="error"></span>
				</div>
			</div>
            <div class="form-group">
				<label class="col-md-4 control-label">Jml Penumpang <span class="required">*</span></label>
				<div class="col-md-7">
					<input type="number" class="form-control" name="jml_pnp" value="<?php echo set_value('jml_pnp'); ?>" required />
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
				echo form_dropdown("kedatangan", $array, set_value('kedatangan'), "class='form-control' data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity'");
				?>
					<span class="error"></span>
				</div>
			</div>
            <div class="form-group">
				<label class="col-md-4 control-label">Dari <span class="required">*</span></label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="dari" value="<?php echo set_value('dari'); ?>" required />
					<span class="error"></span>
				</div>
			</div>
            <div class="form-group">
				<label class="col-md-4 control-label">Tujuan <span class="required">*</span></label>
				<div class="col-md-7">
					<input type="text" class="form-control" name="tujuan" value="<?php echo set_value('tujuan'); ?>" required />
					<span class="error"></span>
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

<div class="zoom-anim-dialog modal-block modal-block-primary mfp-hide" id="EditData">
	<section class="panel" id='view'></section>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		<?php echo ($this->session->flashdata('form_modal') ? "mfp_modal('#add_modal');" : ''); ?>
		$(document).on('click', '.add_data', function () {
			mfp_modal('#add_modal');
		});
	});
</script>