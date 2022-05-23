<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en" class="h-100">

    <head>
        <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= ucwords($title) ?> | <?= APP_NAME ?></title>
        <?= link_tag('assets/images/favicon.png', 'icon', 'image/png') ?>
        <!-- Toastr -->
		<?= link_tag('assets/back/vendor/toastr/css/toastr.min.css', 'stylesheet', 'text/css') ?>
		<?= link_tag('assets/back/css/style.css', 'stylesheet', 'text/css') ?>
    </head>

    <body class="h-100">
        <div id="preloader">
            <div class="sk-three-bounce">
                <div class="sk-child sk-bounce1"></div>
                <div class="sk-child sk-bounce2"></div>
                <div class="sk-child sk-bounce3"></div>
            </div>
        </div>
        <div class="authincation front-end h-100">
            <div class="container h-100">
                <div class="row justify-content-center h-100 align-items-center">
                    <div class="col-md-12 h-100 d-flex align-items-center">
                        <div class="authincation-content style-1">
                            <div class="row h-100">
                                <div class="col-md-6 h-100">
                                    <div class="img-bx">
                                        <?= img('assets/images/login.jpg', '', 'class="img-fluid"') ?>
                                    </div>
                                </div>
                                <?= $contents ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="error_msg" value="<?= $this->session->error ?>" />
        <input type="hidden" name="success_msg" value="<?= $this->session->success ?>" />
        <?= script("assets/back/vendor/global/global.min.js") ?>
        <!-- Toastr -->
        <?= script("assets/back/vendor/toastr/js/toastr.min.js") ?>
        <!-- All init script -->
        <?= script("assets/back/js/custom.js") ?>
    </body>

</html>