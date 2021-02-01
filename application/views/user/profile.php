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
					<li><div class="icon-holder" data-toggle="tooltip" data-original-title="Nomor HP"><i class="fas fa-phone"></i></div> <?php echo !empty($staff['mobileno']) ? $staff['mobileno'] : 'N/A'; ?></li>
                    <li><div class="icon-holder" data-toggle="tooltip" data-original-title="Email"><i class="far fa-envelope"></i></div> <?php echo $staff['email']; ?></li>
                    <li><div class="icon-holder" data-toggle="tooltip" data-original-title="Alamat"><i class="fas fa-home"></i></div> <?php echo !empty($staff['address']) ? $staff['address'] : 'N/A'; ?></li>
				</ul>
			</div>
		</div>
	</div>
	
	<div class="col-md-12">
		<div class="panel-group" id="accordion">
			<div class="panel panel-accordion">
				<div class="panel-heading">
					<h4 class="panel-title">
                        <div class="auth-pan">
                            <button class="btn btn-default btn-circle" id="authentication_btn">
                                <i class="fas fa-unlock-alt"></i> Ganti Password
                            </button>
                        </div>
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#profile">
							<i class="fas fa-user-edit"></i> Informasi User
						</a>
					</h4>
				</div>
				<div id="profile" class="accordion-body">
					<?php echo form_open_multipart($this->uri->uri_string()); ?>
						<div class="panel-body">
                            <fieldset>
                                <input type="hidden" name="staff_id" id="staff_id" value="<?php echo $staff['id']; ?>">
                                <div class="row">
                                    <div class="col-md-4 mb-sm">
                                        <div class="form-group <?php if (form_error('username')) echo 'has-error'; ?>">
                                            <label class="control-label">Username <span class="required">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fas fa-user-lock"></i></span>
                                                <input type="text" class="form-control" name="username" id="username" value="<?php echo set_value('username', $staff['username']); ?>" />
                                            </div>
											<span class="error"><?php echo form_error('username'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-sm">
                                        <div class="form-group <?php if (form_error('user_role')) echo 'has-error'; ?>">
                                            <label class="control-label">Role <span class="required">*</span></label>
                                            <?php
                                                $role_array = $this->app_lib->getRoles();
                                                echo form_dropdown("user_role", $role_array, set_value('user_role', $staff['role_id']), "class='form-control' data-plugin-selectTwo data-width='100%'
                                                data-minimum-results-for-search='Infinity' ");
                                            ?>
											<span class="error"><?php echo form_error('user_role'); ?></span>
                                        </div>
                                    </div>
                                </div>
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
                                        <div class="form-group <?php if (form_error('mobile_no')) echo 'has-error'; ?>">
                                            <label class="control-label">Nomor HP <span class="required">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fas fa-phone-volume"></i></span>
                                                <input class="form-control" name="mobile_no" type="text" value="<?php echo set_value('mobile_no', $staff['mobileno']); ?>">
                                            </div>
											<span class="error"><?php echo form_error('mobile_no'); ?></span>
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
											<label for="input-file-now">Foto Profil</label>
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
									<button type="submit" name="submit" value="update" class="btn btn-default btn-block">Update</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="authentication_modal" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
	<section class="panel">
		<header class="panel-heading">
			<h4 class="panel-title">
				<i class="fas fa-unlock-alt"></i> Ganti Password
			</h4>
		</header>
		<?php echo form_open('user/change_password', array('class' => 'frm-submit')); ?>
        <div class="panel-body">
        	<input type="hidden" name="staff_id" value="<?=$staff['id']?>">
            <div class="form-group">
	            <label for="password" class="control-label">Password <span class="required">*</span></label>
	            <div class="input-group">
	                <input type="password" class="form-control password" name="password" autocomplete="off" />
	                <span class="input-group-addon">
	                    <a href="javascript:void(0);" id="showPassword" ><i class="fas fa-eye"></i></a>
	                </span>
	            </div>
	            <span class="error"></span>
            </div>
        </div>
        <footer class="panel-footer">
            <div class="text-right">
                <button type="submit" class="btn btn-default mr-xs" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">Update</button>
                <button class="btn btn-default modal-dismiss">Close</button>
            </div>
        </footer>
        <?php echo form_close(); ?>
	</section>
</div>

<script type="text/javascript">
	var authenStatus = "<?=$staff['active']?>";
</script>
