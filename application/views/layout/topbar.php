<header class="header">
	<div class="logo-env">
		<a href="<?=base_url();?>" class="logo">
			<?php echo ($theme_config['dark_skin'] == 'true' ? '<img src="'.base_url('uploads/app_image/logo_putih.png').'" height="40">' : '<img src="'.base_url('uploads/app_image/logo_small.png').'" height="40">');?>
		</a>
		<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
			<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
		</div>
	</div>

	<div class="header-left hidden-xs">
		<ul class="header-menu">
			<!-- sidebar toggle button -->
			<li>
				<div class="header-menu-icon sidebar-toggle" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
					<i class="fas fa-bars" aria-label="Toggle sidebar"></i>
				</div>
			</li>
			<!-- full screen button -->
			<li>
				<div class="header-menu-icon s-expand">
					<i class="fas fa-expand"></i>
				</div>
			</li>
		</ul>
	</div>

	<div class="header-right">
		<ul class="header-menu">
			<li>
				<a href="#" class="dropdown-toggle header-menu-icon" data-toggle="dropdown">
					<i class="far fa-bell"></i>
					<span class="badge">0</span>
				</a>
				<div class="dropdown-menu header-menubox qmsg-box-mw">
					<div class="notification-title">
						<i class="far fa-bell"></i> Notifikasi
					</div>
					<div class="content">
						<ul>
							<li class="text-center">Tidak ada notifikasi</li>
						</ul>
					</div>
					<div class="notification-footer">
						<div class="text-right">
							<a href="<?php echo base_url('#');?>" class="view-more">Lihat Semua</a>
						</div>
					</div>
				</div>
			</li>
		</ul>

		<!-- user profile box -->
		<span class="separator"></span>
		<div id="userbox" class="userbox">
			<a href="#" data-toggle="dropdown">
				<figure class="profile-picture">
					<img src="<?=get_image_url(get_loggedin_user_type(), $this->session->userdata('logger_photo'));?>" alt="user-image" class="img-circle" height="35">
				</figure>
			</a>
			<div class="dropdown-menu">
				<ul class="dropdown-user list-unstyled">
					<li class="user-p-box">
						<div class="dw-user-box">
							<div class="u-img">
								<img src="<?=get_image_url(get_loggedin_user_type(), $this->session->userdata('logger_photo'));?>" alt="user">
							</div>
							<div class="u-text">
								<h4><?=$this->session->userdata('nama');?></h4>
								<p class="text-muted"><?=ucfirst(loggedin_role_name());?></p>
								<a href="<?=base_url('logout'); ?>" class="btn btn-danger btn-xs"><i class="fas fa-sign-out-alt"></i> Logout</a>
							</div>
						</div>
					</li>
					<li role="separator" class="divider"></li>
					<li><a href="<?=base_url('profile');?>"><i class="fas fa-user-shield"></i> Profile</a></li>
					<li><a href="<?=base_url('profile/password');?>"><i class="fas fa-mars-stroke-h"></i> Ganti Password</a></li>
					<li role="separator" class="divider"></li>
					<li><a href="<?=base_url('logout');?>"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
				</ul>
			</div>
		</div>
	</div>
</header>