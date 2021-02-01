<?php $disabled = (is_admin_loggedin() ?  '' : 'disabled');?>
<div class="row appear-animation" data-appear-animation="<?=$global_config['animations'] ?>">
	<div class="col-md-12 mb-lg">
		<div class="profile-head social">
			<div class="col-md-12 col-lg-4 col-xl-3">
				<div class="image-content-center user-pro">
					<div class="preview">
						<img src="<?=get_image_url('staff', $staff['photo'])?>">
					</div>
				</div>
			</div>
			<div class="col-md-12 col-lg-5 col-xl-5">
				<h5><?php echo $staff['nama']; ?></h5>
				<p><?php echo ucfirst($staff['role'])?></p>
				<ul>
				<li><div class="icon-holder" data-toggle="tooltip" data-original-title="Staff ID"><i class="far fa-id-card"></i></div> <?php echo $staff['staff_id']; ?></li>
					<li><div class="icon-holder" data-toggle="tooltip" data-original-title="Nomor Telp"><i class="fas fa-phone"></i></div> <?php echo !empty($staff['mobileno']) ? $staff['mobileno'] : 'N/A'; ?></li>
                    <li><div class="icon-holder" data-toggle="tooltip" data-original-title="Email"><i class="far fa-envelope"></i></div> <?php echo $staff['email']; ?></li>
                    <li><div class="icon-holder" data-toggle="tooltip" data-original-title="Alamat"><i class="fas fa-home"></i></div> <?php echo !empty($staff['address']) ? $staff['address'] : 'N/A'; ?></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="far fa-edit"></i> Profil</h4>
			</header>
            <?php echo form_open_multipart($this->uri->uri_string()); ?>
			<div class="panel-body">
				<fieldset>
					<input type="hidden" name="staff_id" id="staff_id" value="<?php echo $staff['id']; ?>">
					<!-- Employee Details -->
					<div class="row">
						<div class="col-md-4 mb-sm">
							<div class="form-group <?php if (form_error('nama')) echo 'has-error'; ?>">
								<label class="control-label">Nama Lengkap <span class="required">*</span></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="far fa-user"></i></span>
									<input type="text" class="form-control" name="nama" value="<?php echo set_value('nama', $staff['nama']); ?>" />
								</div>
								<span class="error"><?php echo form_error('nama'); ?></span>
							</div>
						</div>
						<div class="col-md-4 mb-sm">
							<div class="form-group <?php if (form_error('mobileno')) echo 'has-error'; ?>">
								<label class="control-label">Nomor HP <span class="required">*</span></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-phone-volume"></i></span>
									<input class="form-control" name="mobileno" type="text" value="<?php echo set_value('mobileno', $staff['mobileno']); ?>">
								</div>
								<span class="error"><?php echo form_error('mobileno'); ?></span>
							</div>
						</div>
						<div class="col-md-4 mb-sm">
							<div class="form-group <?php if (form_error('email')) echo 'has-error'; ?>">
								<label class="control-label">Email <span class="required">*</span></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="far fa-envelope-open"></i></span>
									<input type="text" class="form-control" name="email" id="email" value="<?php echo set_value('email', $staff['email']); ?>" />
								</div>
								<span class="error"><?php echo form_error('email'); ?></span>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 mb-sm">
							<div class="form-group">
								<label class="control-label">Alamat</label>
								<textarea class="form-control" rows="2" name="alamat" placeholder="Alamat" ><?php echo set_value('alamat', $staff['alamat']); ?></textarea>
							</div>
						</div>
					</div>
									
					<div class="row mb-md">
						<div class="col-md-12">
							<div class="form-group">
								<label for="input-file-now">Photo Profile</label>
								<input type="file" name="user_photo" class="dropify" data-default-file="<?=get_image_url('staff', $staff['photo'])?>"/>
								<span class="error"><?php echo form_error('user_photo'); ?></span>
							</div>
						</div>
						<input type="hidden" name="old_user_photo" value="<?=$staff['photo']?>">
					</div>
				</fieldset>
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-md-offset-9 col-md-3">
						<button class="btn btn-default btn-block" type="submit"><i class="fas fa-plus-circle"></i> Update</button>
					</div>	
				</div>
			</div>
			<?php echo form_close(); ?>
		</section>
	</div>
</div>
