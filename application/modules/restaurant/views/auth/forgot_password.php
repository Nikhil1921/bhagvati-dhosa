<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-6">
    <div class="auth-form">
        <h4 class="main-title"><?= ucwords($title) ?></h4>
        <?= form_open() ?>
            <div class="form-group mb-3 pb-3">
                <?= form_label('Mobile No.', 'mobile', 'class="font-w600"') ?>
                <?= form_input([
                    'class' => "form-control solid",
                    'type' => "text",
                    'id' => "mobile",
                    'name' => "mobile",
                    'maxlength' => 10,
                    'required' => "",
                    'placeholder' => "Enter Mobile No.",
                    'value' => set_value('mobile')
                ]); ?>
                <?= form_error('mobile') ?>
            </div>
            <div class="text-center">
                <?= form_button([
                    'type'    => 'submit',
                    'class'   => 'btn btn-primary btn-block rounded',
                    'content' => 'Get OTP'
                ]); ?>
            </div>
        <?= form_close() ?>
        <div class="new-account mt-3">
            <p><?= anchor(admin('login'), 'click here', 'class="text-primary text-capitalize"') ?> to login</p>
        </div>
    </div>
</div>