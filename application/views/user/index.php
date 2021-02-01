<section class="panel">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<li class="<?php echo (!isset($validation_error) ? 'active' : ''); ?>">
				<a href="#list" data-toggle="tab"><i class="fas fa-list-ul"></i> List User</a>
			</li>
			<?php if (get_permission('pengaturan_staff', 'is_add')){ ?>
			<li class="<?php echo (isset($validation_error) ? 'active' : ''); ?>">
				<a href="#create" data-toggle="tab"><i class="far fa-edit"></i> Tambah User</a>
			</li>
			<?php } ?>
		</ul>
		<div class="tab-content">
			<div id="list" class="tab-pane <?php echo (!isset($validation_error) ? 'active' : ''); ?>">
				<div class="mb-md">
					<div class="export_title">List User</div>
					<table class="table table-bordered table-hover table-condensed table_default" cellspacing="0" width="100%" id="table-export">
						<thead>
							<tr>
								<th width="50">No.</th>
								<th>Photo</th>
								<th>Role</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Nomor HP</th>
                                <th>Alamat</th>
								<th class="min-w-xs">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php $count = 1; if (!empty($stafflist)){ foreach ($stafflist as $row): ?>
							<tr>
								<td><?php echo $count++; ?></td>
								<td class="center">
									<img src="<?php echo get_image_url('staff', $row->photo); ?>" height="50" />
								</td>
								<td><b><?php echo $row->role; ?></b></td>
								<td><?php echo $row->nama; ?></td>
								<td><?php echo $row->email; ?></td>
								<td><?php echo $row->mobileno; ?></td>
								<td><?php echo $row->alamat; ?></td>
								<td class="min-w-c">
								<?php if (get_permission('pengaturan_staff', 'is_edit')): ?>
									<a href="<?php echo base_url('user/profile/'.$row->id); ?>" class="btn btn-circle btn-default icon" data-toggle="tooltip" 
									data-original-title="Edit Profil"><i class="far fa-arrow-alt-circle-right"></i>
									</a>
								<?php endif; if (get_permission('pengaturan_staff', 'is_delete')): ?>
									<?php echo btn_delete('user/delete/' . $row->id); ?>
								<?php endif; ?>
								</td>
							</tr>
							<?php endforeach; }?>
						</tbody>
					</table>
				</div>
			</div>

			<?php if (get_permission('pengaturan_staff', 'is_add')){ ?>
			<div class="tab-pane <?php echo (isset($validation_error) ? 'active' : ''); ?>" id="create">
			<?php echo form_open_multipart($this->uri->uri_string()); ?>
					<!-- Login Details -->
					<div class="headers-line">
						<i class="fas fa-user-lock"></i> Login Detail
					</div>
					<div class="row mb-lg">
						<div class="col-md-3 mb-sm">
							<div class="form-group <?php if (form_error('user_role')) echo 'has-error'; ?>">
								<label class="control-label">Role <span class="required">*</span></label>
								<?php
									$role_list = $this->app_lib->getRoles();
									echo form_dropdown("user_role", $role_list, set_value('user_role'), "class='form-control'
									data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
								?>
								<span class="error"><?php echo form_error('user_role'); ?></span>
							</div>
						</div>
						<div class="col-md-3 mb-sm">
							<div class="form-group <?php if (form_error('username')) echo 'has-error'; ?>">
								<label class="control-label">Username <span class="required">*</span></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-user-lock"></i></span>
									<input type="text" class="form-control" name="username" id="username" value="<?php echo set_value('username'); ?>" />
								</div>
								<span class="error"><?php echo form_error('username'); ?></span>
							</div>
						</div>
						<div class="col-md-3 mb-sm">
							<div class="form-group <?php if (form_error('password')) echo 'has-error'; ?>">
								<label class="control-label">Password <span class="required">*</span></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-unlock-alt"></i></span>
									<input type="password" class="form-control" name="password" value="<?php echo set_value('password'); ?>" />
								</div>
								<span class="error"><?php echo form_error('password'); ?></span>
							</div>
						</div>
						<div class="col-md-3 mb-sm">
							<div class="form-group <?php if (form_error('retype_password')) echo 'has-error'; ?>">
								<label class="control-label">Ulangi Password <span class="required">*</span></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-unlock-alt"></i></span>
									<input type="password" class="form-control" name="retype_password"  value="<?php echo set_value('retype_password'); ?>" />
								</div>
								<span class="error"><?php echo form_error('retype_password'); ?></span>
							</div>
						</div>
					</div>
					<!-- Basic Details -->
					<div class="headers-line">
						<i class="fas fa-user-check"></i> Informasi User
					</div>
					<div class="row">
						<div class="col-md-4 mb-sm">
							<div class="form-group <?php if (form_error('nama')) echo 'has-error'; ?>">
								<label class="control-label">Nama Lengkap <span class="required">*</span></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="far fa-user"></i></span>
									<input class="form-control" name="nama" type="text" value="<?php echo set_value('nama'); ?>">
								</div>
								<span class="error"><?php echo form_error('nama'); ?></span>
							</div>
						</div>
						<div class="col-md-4 mb-sm">
							<div class="form-group <?php if (form_error('mobile_no')) echo 'has-error'; ?>">
								<label class="control-label">Nomor HP <span class="required">*</span></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-phone-volume"></i></span>
									<input class="form-control" name="mobile_no" type="text" value="<?php echo set_value('mobile_no'); ?>">
								</div>
								<span class="error"><?php echo form_error('mobile_no'); ?></span>
							</div>
						</div>
						<div class="col-md-4 mb-sm">
							<div class="form-group <?php if (form_error('email')) echo 'has-error'; ?>">
								<label class="control-label">Email <span class="required">*</span></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="far fa-envelope-open"></i></span>
									<input type="text" class="form-control" name="email" id="email" value="<?php echo set_value('email'); ?>" />
								</div>
								<span class="error"><?php echo form_error('email'); ?></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 mb-sm">
							<div class="form-group">
								<label class="control-label">Alamat</label>
								<textarea class="form-control" rows="3" name="alamat" placeholder="Alamat Rumah" ><?php echo set_value('alamat'); ?></textarea>
							</div>
						</div>
					</div>
					<div class="row mb-md">
						<div class="col-md-12">
							<div class="form-group">
								<label for="input-file-now">Foto Profil</label>
								<input type="file" name="user_photo" class="dropify" data-allowed-file-extensions="jpg png" data-height="120" />
							</div>
						</div>
					</div>
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-offset-10 col-md-2">
							<button type="submit" name="submit" value="save" class="btn btn btn-default btn-block"> <i class="fas fa-plus-circle"></i> Save</button>
						</div>
					</div>
				</footer>
			<?php echo form_close(); ?>
            <?php } ?>
		</div>
	</div>
</section>