<div class="row">
<?php if (get_permission('pengaturan_po', 'is_add')): ?>
	<div class="col-md-4">
		<section class="panel">
			<header class="panel-heading">
            <h4 class="panel-title"><i class="fas fa-user-plus"></i> Tambah P.O Bus</h4>
			</header>
			<?php echo form_open($this->uri->uri_string());?>
				<div class="panel-body">
					<div class="form-group">
						<label class="control-label">Nama P.O <span class="required">*</span></label>
						<input type="text" class="form-control" name="nama" value="<?=set_value('nama')?>" />
						<span class="error"><?=form_error('nama')?></span>
					</div>
				</div>
				<div class="panel-footer">
					<div class="row">
						<div class="col-md-12">
							<button class="btn btn-default pull-right" type="submit" name="save" value="1">
								<i class="fas fa-plus-circle"></i> Simpan
							</button>
						</div>	
					</div>
				</div>
			<?php echo form_close();?>
		</section>
	</div>
<?php endif; ?>
<?php if (get_permission('pengaturan_po', 'is_view')): ?>
	<div class="col-md-<?php if (get_permission('pengaturan_po', 'is_add')){ echo "8"; }else{ echo "12"; } ?>">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fas fa-list-ul"></i> Data P.O Bus</h4>
			</header>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered table-hover table-condensed mb-none">
						<thead>
							<tr>
								<th width="5%">No.</th>
								<th>Nama P.O Bus</th>
								<th width="15%">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$count = 1;
							if (count($po)){
								foreach ($po as $row):
							?>
							<tr>
								<td><?php echo $count++;?></td>
								<td><?php echo $row['nama']; ?></td>
								<td>
								<?php if (get_permission('pengaturan_po', 'is_edit')): ?>
									<a class="btn btn-default btn-circle icon evt_modal" href="javascript:void(0);" data-id="<?=$row['id']?>" data-nama="<?=$row['nama']?>">
										<i class="fas fa-pen-nib"></i>
									</a>
								<?php endif; if (get_permission('pengaturan_po', 'is_delete')): ?>
								    <?php echo btn_delete('po/pengaturan_delete/' . $row['id']);?>
								<?php endif; ?>
								</td>
							</tr>
							<?php
								endforeach;
							}else{
								echo '<tr><td colspan="5"><h5 class="text-danger text-center">Data P.O Bus masih kosong.</td></tr>';
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>
<?php endif; ?>
<?php if (get_permission('pengaturan_po', 'is_edit')): ?>
<div class="zoom-anim-dialog modal-block modal-block-primary mfp-hide" id="modal">
	<section class="panel">
		<?php echo form_open('po/pengaturan_edit', array('class' => 'frm-submit')); ?>
			<header class="panel-heading">
				<h4 class="panel-title"><i class="far fa-edit"></i> Edit P.O Bus</h4>
			</header>
			<div class="panel-body">
				<input type="hidden" name="id" id="id" value="" />
				
				<div class="form-group mb-md">
					<label class="control-label">Nama P.O Bus<span class="required">*</span></label>
					<input type="text" class="form-control" name="nama" id="nama" value="" />
					<span class="error"></span>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<button type="submit" class="btn btn-default" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
							<i class="fas fa-plus-circle"></i> Update
						</button>
						<button class="btn btn-default modal-dismiss">Batal</button>
					</div>
				</div>
			</footer>
		<?php echo form_close();?>
	</section>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$('.evt_modal').on('click', function() {
			var id = $(this).data('id');
			var nama = $(this).data('nama');
			$('#id').val(id);
			$('#nama').val(nama);
			mfp_modal('#modal');
		});
	});
</script>
<?php endif; ?>