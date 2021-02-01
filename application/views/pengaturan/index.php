<section class="panel appear-animation" data-appear-animation="<?php echo $global_config['animations']; ?>" data-appear-animation-delay="100">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<li <?=(empty($this->session->flashdata('active')) ? 'class="active"' : '');?>>
				<a href="#setting" data-toggle="tab">
					<i class="fas fa-chalkboard-teacher"></i> 
				   <span class="hidden-xs"> Pengaturan Umum</span>
				</a>
			</li>
			<li <?=($this->session->flashdata('active') == 2 ? 'class="active"' : '');?>>
				<a href="#theme" data-toggle="tab">
				   <i class="fas fa-paint-roller"></i>
				   <span class="hidden-xs"> Pengaturan Tema</span>
				</a>
			
			</li>
		</ul>

		<div class="tab-content">
			<div class="tab-pane box <?=(empty($this->session->flashdata('active')) ? 'active' : '');?>" id="setting">
				<?php echo form_open($this->uri->uri_string(), array( 'class' 	=> 'validate form-horizontal form-bordered' )); ?>
				<div class="form-group">
					<label class="col-md-3 control-label">Nama Aplikasi</label>
					<div class="col-md-6">
						<input type="text" class="form-control" name="nama_app" value="<?=set_value('nama_app', $global_config['nama_app'])?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Nomor Telp</label>
					<div class="col-md-6">
						<input type="text" class="form-control" name="telp" value="<?=set_value('telp', $global_config['telp'])?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Alamat</label>
					<div class="col-md-6">
						<textarea name="alamat" rows="2" class="form-control" aria-required="true"><?=set_value('alamat', $global_config['alamat'])?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Timezone</label>
					<div class="col-md-6">
						<?php
						$timezones = $this->app_lib->timezone_list();
						echo form_dropdown("timezone", $timezones, set_value('timezone', $global_config['timezone']), "class='form-control populate' required id='timezones' 
						data-plugin-selectTwo data-width='100%'");
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label"> Animasi </label>
					<div class="col-md-6">
						<?php
						$getAnimationslist = $this->app_lib->getAnimationslist();
						echo form_dropdown("animations", $getAnimationslist, set_value('animations', $global_config['animations']), "class='form-control populate' required
						id='timezones' data-plugin-selectTwo data-width='100%'");
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Format Tanggal</label>
					<div class="col-md-6">
						<?php
						$getDateformat = $this->app_lib->getDateformat();
						echo form_dropdown("date_format", $getDateformat, set_value('date_format', $global_config['date_format']), "class='form-control' id='date_format' 
						data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Mata Uang</label>
					<div class="col-md-6">
						<input type="text" class="form-control" name="mata_uang" value="<?=set_value('mata_uang', $global_config['mata_uang'])?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Footer Text</label>
					<div class="col-md-6">
						<input type="text" class="form-control" name="footer_text" value="<?=set_value('footer_text', $global_config['footer_text'])?>" />
					</div>
				</div>

				<footer class="panel-footer mt-lg">
					<div class="row">
						<div class="col-md-2 col-sm-offset-3">
							<button type="submit" class="btn btn btn-default btn-block" name="submit" value="setting">
								<i class="fas fa-plus-circle"></i> Simpan
							</button>
						</div>
					</div>
				</footer>
				<?php echo form_close(); ?>
			</div>

			<div class="tab-pane box <?=($this->session->flashdata('active') == 2 ? 'active' : '');?>" id="theme">
				<?php
					echo form_open($this->uri->uri_string(), array(
						'method'	=> 'post',
						'class' 	=> 'validate form-horizontal form-bordered'
					));
				?>
				<div class="form-group">
					<label class="col-md-2 control-label" for="zoomcontrol">Theme</label>
					<div class="col-md-8">
						<ul class="list-unstyled thememenu-sy">
							<li>
								<div class="theme-box">
									<label> 
										<input name="dark_skin" value="false" type="radio" <?=($theme_config['dark_skin'] == 'false' ? 'checked' : '');?>>
										<div class="theme-img">
											<img src="<?=base_url('assets/images/theme/light.png')?>">
										</div>
									</label>
								</div>
							</li>
							<li>
								<div class="theme-box">
									<label >
										<input name="dark_skin" value="true" type="radio" <?=($theme_config['dark_skin'] == 'true' ? 'checked' : '');?> >
										<div class="theme-img">
											<img src="<?=base_url('assets/images/theme/dark.png')?>">
										</div>
									</label>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="zoomcontrol">Border</label>
					<div class="col-md-8 mb-md">
						<ul class="list-unstyled thememenu-sy">
							<li>
								<div class="theme-box">
									<label> 
										<input name="border_mode" value="true" type="radio" <?=($theme_config['border_mode'] == 'true' ? 'checked' : '')?> >
										<div class="theme-img">
											<img src="<?=base_url('assets/images/theme/rounded.png')?>">
										</div>
									</label>
								</div>
							</li>
							<li>
								<div class="theme-box">
									<label >
										<input name="border_mode" value="false" type="radio" <?=($theme_config['border_mode'] == 'false' ? 'checked' : '')?> >
										<div class="theme-img">
											<img src="<?=base_url('assets/images/theme/square.png')?>">
										</div>
									</label>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-2 col-sm-offset-3">
							<button type="submit" class="btn btn btn-default btn-block" name="submit" value="theme">
								<i class="fas fa-plus-circle"></i> Simpan
							</button>
						</div>
					</div>
				</footer>
				<?php echo form_close(); ?>
			</div>
			
		</div>
	</div>
</section>