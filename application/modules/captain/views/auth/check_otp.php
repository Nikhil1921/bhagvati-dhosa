<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-6">
    <div class="auth-form">
        <h4 class="main-title"><?= ucwords($title) ?></h4>
        <?= form_open() ?>
            <div class="form-group mb-3 pb-3">
                <?= form_label('Your OTP', 'otp', 'class="font-w600"') ?>
                <?= form_input([
                    'class' => "form-control solid",
                    'type' => "text",
                    'id' => "otp",
                    'name' => "otp",
                    'maxlength' => 6,
                    'required' => "",
                    'value' => set_value('otp')
                ]); ?>
                <?= form_error('otp') ?>
            </div>
            <div class="text-center">
                <?= form_button([
                    'type'    => 'submit',
                    'class'   => 'btn btn-primary btn-block rounded',
                    'content' => 'Check OTP'
                ]); ?>
            </div>
        <?= form_close() ?>
    </div>
</div>