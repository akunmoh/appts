<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width,initial-scale=1" name="viewport">
    <title>Login | RM. Taman Selera</title>
    <link href="<?=base_url('assets/images/favicon.png');?>" rel="shortcut icon">
    <!-- Web Fonts  -->
    <link href="<?=is_secure('fonts.googleapis.com/css?family=Signika:300,400,600,700');?>" rel="stylesheet">
    <link href="<?=base_url('assets/vendor/bootstrap/css/bootstrap.css');?>" rel="stylesheet">
    <link href="<?=base_url('assets/vendor/font-awesome/css/all.min.css'); ?>" rel="stylesheet">
    <script src="<?=base_url('assets/vendor/jquery/jquery.js');?>"></script>
    <!-- sweetalert js/css -->
    <link href="<?=base_url('assets/vendor/sweetalert/sweetalert-custom.css');?>" rel="stylesheet">
    <script src="<?=base_url('assets/vendor/sweetalert/sweetalert.min.js');?>"></script>
    <!-- login page style css -->
    <link href="<?=base_url('assets/login_page/css/style.css');?>" rel="stylesheet">
    <script type="text/javascript">
        var base_url = '<?=base_url() ?>';
    </script>
</head>

<body>
    <div class="auth-main">
        <div class="container">
            <div class="slideIn">
                <div class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-sm-12 col-xs-12 no-padding fitxt-center">
                    <div class="image-area">
                        <div class="content">
                            <div class="center img-hol-p">
                                <img src="<?=base_url('uploads/app_image/logo_putih.png');?>" height="57">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-lg-offset-right-1 col-md-6 col-md-offset-right-1 col-sm-12 col-xs-12 no-padding">
                    <div class="sign-area">
                        <div class="sign-hader">
                            <img src="<?=base_url('uploads/app_image/logo.png');?>" height="90">
                            <h2><?=$global_config['nama_app'];?></h2>
                        </div>
                        <?=form_open($this->uri->uri_string()); ?>
                        <div class="form-group <?php if (form_error('username')) echo 'has-error'; ?>">
                            <div class="input-group input-group-icon">
                                <span class="input-group-addon">
                                    <span class="icon"><i class="far fa-user"></i></span>
                                </span>
                                <input type="text" class="form-control" name="username" value="<?=set_value('username');?>" placeholder="Username" />
                            </div>
                            <span class="error"><?=form_error('username'); ?></span>
                        </div>
                        <div class="form-group <?php if (form_error('password')) echo 'has-error'; ?>">
                            <div class="input-group input-group-icon">
                                <span class="input-group-addon">
                                    <span class="icon"><i class="fas fa-unlock-alt"></i></span>
                                </span>
                                <input type="password" class="form-control input-rounded" name="password" placeholder="Password" />
                            </div>
                            <span class="error"><?=form_error('password'); ?></span>
                        </div>

                        <div class="form-group">
                            <button type="submit" id="btn_submit" class="btn btn-block btn-round">
                                <i class="fas fa-sign-in-alt"></i> LOGIN
                            </button>
                        </div>
                        <div class="sign-footer">
                            <p><?=$global_config['footer_text'];?></p>
                        </div>
                        <?=form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?=base_url('assets/vendor/bootstrap/js/bootstrap.js');?>"></script>
    <script src="<?=base_url('assets/vendor/jquery-placeholder/jquery-placeholder.js');?>"></script>
    <!-- backstretch js -->
    <script src="<?=base_url('assets/login_page/js/jquery.backstretch.min.js');?>"></script>
    <script src="<?=base_url('assets/login_page/js/custom.js');?>"></script>

    <?php
		$alertclass = "";
		if($this->session->flashdata('alert-message-success')){
			$alertclass = "success";
		} else if ($this->session->flashdata('alert-message-error')){
			$alertclass = "error";
		} else if ($this->session->flashdata('alert-message-info')){
			$alertclass = "info";
		}
		if($alertclass != ''):
			$alert_message = $this->session->flashdata('alert-message-'. $alertclass);
		?>
    <script type="text/javascript">
        swal({
            toast: true,
            position: 'top-end',
            type: '<?=$alertclass;?>',
            title: '<?=$alert_message;?>',
            confirmButtonClass: 'btn btn-default',
            buttonsStyling: false,
            timer: 8000
        })
    </script>
    <?php endif; ?>
</body>

</html>