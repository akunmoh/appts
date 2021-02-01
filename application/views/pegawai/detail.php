<div class="row appear-animation" data-appear-animation="<?=$global_config['animations'] ?>">
    <div class="col-md-12 mb-lg">
        <div class="profile-head social">
            <div class="col-md-12 col-lg-4 col-xl-3">
                <div class="image-content-center user-pro">
                    <div class="preview">
                        <img src="<?=get_image_url('pegawai', $pegawai['photo'])?>">
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-5 col-xl-5">
                <h5><?php echo $pegawai['nama']; ?></h5>
                <p><?php echo $pegawai['nama_lokasi'];?> / <?php echo $pegawai['nama_jabatan']; ?></p>
                <ul>
                    <li>
                        <div class="icon-holder" data-toggle="tooltip" data-original-title="Pegawai ID"><i
                                class="far fa-id-card"></i></div> <?php echo $pegawai['pegawai_id']; ?>
                    </li>
                    <li>
                        <div class="icon-holder" data-toggle="tooltip" data-original-title="Nomor HP"><i
                                class="fas fa-phone"></i></div>
                        <?php echo !empty($pegawai['notelp']) ? $pegawai['notelp'] : 'N/A'; ?>
                    </li>
                    <li>
                        <div class="icon-holder" data-toggle="tooltip" data-original-title="Tanggal Lahir"><i
                                class="fas fa-birthday-cake"></i></div> <?php echo date_indo($pegawai['tgl_lahir']); ?>
                    </li>
                    <li>
                        <div class="icon-holder" data-toggle="tooltip" data-original-title="Jenis Kelamin"><i
                                class="fas fa-venus-mars"></i></div>
                        <?=($pegawai['jenis_kelamin'] == 1 ? 'Laki-Laki' : 'Perempuan'); ?>
                    </li>
                    <li>
                        <div class="icon-holder" data-toggle="tooltip" data-original-title="Alamat"><i
                                class="fas fa-home"></i></div>
                        <?php echo !empty($pegawai['alamat']) ? $pegawai['alamat'] : 'N/A'; ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="panel-group" id="accordion">
            <div class="panel panel-accordion">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#profile">
                            <i class="fas fa-user-edit"></i> Informasi Pegawai
                        </a>
                    </h4>
                </div>
                <div id="profile" class="accordion-body collapse <?=($this->session->flashdata('profile_tab') ? 'in' : ''); ?>">
                    <?php echo form_open_multipart($this->uri->uri_string()); ?>
                    <input type="hidden" name="pegawai_id" id="pegawai_id" value="<?php echo $pegawai['id']; ?>">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4 mb-sm">
                                <div class="form-group <?php if (form_error('lokasi_id')) echo 'has-error'; ?>">
                                    <label class="control-label">Lokasi Kerja <span class="required">*</span></label>
                                    <?php
						echo form_dropdown("lokasi_id", $lokasilist, set_value('lokasi_id',$pegawai['lokasi_id']), "class='form-control'
						data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
						?>
                                    <span class="error"><?php echo form_error('lokasi_id'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-sm">
                                <div class="form-group <?php if (form_error('jabatan_id')) echo 'has-error'; ?>">
                                    <label class="control-label">Jabatan <span class="required">*</span></label>
                                    <?php
						echo form_dropdown("jabatan_id", $jabatanlist, set_value('jabatan_id',$pegawai['jabatan_id']), "class='form-control'
						data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
						?>
                                    <span class="error"><?php echo form_error('jabatan_id'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-sm">
                                <div class="form-group <?php if (form_error('shift_id')) echo 'has-error'; ?>">
                                    <label class="control-label">Shift <span class="required">*</span></label>
                                    <?php
						echo form_dropdown("shift_id", $shiftlist, set_value('shift_id',$pegawai['shift_id']), "class='form-control'
						data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
						?>
                                    <span class="error"><?php echo form_error('shift_id'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mb-sm">
                                <div class="form-group <?php if (form_error('nama')) echo 'has-error'; ?>">
                                    <label class="control-label">Nama Lengkap <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="far fa-user"></i></span>
                                        <input class="form-control" name="nama" type="text"
                                            value="<?php echo set_value('nama', $pegawai['nama']); ?>">
                                    </div>
                                    <span class="error"><?php echo form_error('nama'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-sm">
                                <div class="form-group <?php if (form_error('notelp')) echo 'has-error'; ?>">
                                    <label class="control-label">Nomor Telp <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-tablet"></i></span>
                                        <input class="form-control" name="notelp" type="text"
                                            value="<?php echo set_value('notelp',$pegawai['notelp']); ?>">
                                    </div>
                                    <span class="error"><?php echo form_error('notelp'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-sm">
                                <div class="form-group <?php if (form_error('tempat_lahir')) echo 'has-error'; ?>">
                                    <label class="control-label">Tempat Lahir</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                        <input class="form-control" name="tempat_lahir" type="text"
                                            value="<?php echo set_value('tempat_lahir',$pegawai['tempat_lahir']); ?>">
                                    </div>
                                    <span class="error"><?php echo form_error('tempat_lahir'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-sm">
                                <div class="form-group <?php if (form_error('tgl_lahir')) echo 'has-error'; ?>">
                                    <label class="control-label">Tanggal Lahir</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-birthday-cake"></i></span>
                                        <input class="form-control" name="tgl_lahir" autocomplete="off"
                                            value="<?=set_value('tgl_lahir',$pegawai['tgl_lahir'])?>" data-plugin-datepicker
                                            data-plugin-options='{ "startView": 2 }' type="text">
                                    </div>
                                    <span class="error"><?php echo form_error('tgl_lahir'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-sm">
                                <div class="form-group <?php if (form_error('jenis_kelamin')) echo 'has-error'; ?>">
                                    <label class="control-label">Jenis Kelamin</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-venus-mars"></i></span>
                                        <?php
							$gender = $this->app_lib->get_gender();
							echo form_dropdown("jenis_kelamin", $gender, set_value('jenis_kelamin',$pegawai['jenis_kelamin']), "class='form-control populate' data-plugin-selectTwo
							data-width='100%' data-minimum-results-for-search='Infinity' ");
							?>
                                    </div>
                                    <span class="error"><?php echo form_error('jenis_kelamin'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-sm">
                                <div class="form-group <?php if (form_error('pendidikan')) echo 'has-error'; ?>">
                                    <label class="control-label">Pendidikan<span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-graduation-cap"></i></span>
                                        <?php
							$pendidikan = $this->app_lib->get_pendidikan();
							echo form_dropdown("pendidikan", $pendidikan, set_value('pendidikan',$pegawai['pendidikan']), "class='form-control populate' data-plugin-selectTwo
							data-width='100%' data-minimum-results-for-search='Infinity' ");
							?>
                                    </div>
                                    <span class="error"><?php echo form_error('pendidikan'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-sm">
                                <div class="form-group <?php if (form_error('agama')) echo 'has-error'; ?>">
                                    <label class="control-label">Agama</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-praying-hands"></i></span>
                                        <?php
							$agama = $this->app_lib->get_agama();
							echo form_dropdown("agama", $agama, set_value('agama',$pegawai['agama']), "class='form-control populate' data-plugin-selectTwo
							data-width='100%' data-minimum-results-for-search='Infinity' ");
							?>
                                    </div>
                                    <span class="error"><?php echo form_error('agama'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-sm">
                                <div class="form-group <?php if (form_error('status_pernikahan')) echo 'has-error'; ?>">
                                    <label class="control-label">Status Pernikahan</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-user-friends"></i></span>
                                        <?php
							$pernikahan = $this->app_lib->get_pernikahan();
							echo form_dropdown("status_pernikahan", $pernikahan, set_value('status_pernikahan',$pegawai['status_pernikahan']), "class='form-control populate' data-plugin-selectTwo
							data-width='100%' data-minimum-results-for-search='Infinity' ");
							?>
                                    </div>
                                    <span class="error"><?php echo form_error('status_pernikahan'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-sm">
                                <div class="form-group <?php if (form_error('gaji_pokok')) echo 'has-error'; ?>">
                                    <label class="control-label">Gaji Pokok <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-money-bill-wave"></i></span>
                                        <input class="form-control" name="gaji_pokok" id='nominal' type="text"
                                            value="<?php echo set_value('gaji_pokok', $pegawai['gaji_pokok']); ?>" required>
                                    </div>
                                    <span class="error"><?php echo form_error('gaji_pokok'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-sm">
                                <div class="form-group <?php if (form_error('alamat')) echo 'has-error'; ?>">
                                    <label class="control-label">Alamat<span class="required">*</span></label>
                                    <textarea class="form-control" rows="3" name="alamat"
                                        placeholder="Alamat Rumah"><?php echo set_value('alamat',$pegawai['alamat']); ?></textarea>
                                    <span class="error"><?php echo form_error('alamat'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-md">
                            <label class="control-label">Photo</label>
                            <input type="file" name="user_photo" class="dropify" data-default-file="<?=get_image_url('pegawai', $pegawai['photo'])?>"/>
                            <input type="hidden" name="old_user_photo" value="<?=$pegawai['photo']?>">
                        </div>
                    </div>


                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-offset-9 col-md-3">
                                <button type="submit" name="submit" value="update"
                                    class="btn btn-default btn-block">Update</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>