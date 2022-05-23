<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-6">
    <div class="auth-form">
        <h4 class="main-title"><?= ucwords($title) ?></h4>
        <?= form_open() ?>
            <div class="form-group mb-3 pb-3">
                <?= form_label('Password', 'password', 'class="font-w600"') ?>
                <?= form_input([
                    'class' => "form-control solid",
                    'type' => "password",
                    'id' => "password",
                    'name' => "password",
                    'maxlength' => 255,
                    'required' => ""
                ]); ?>
                <?= form_error('password') ?>
            </div>
            <div class="text-center">
                <?= form_button([
                    'type'    => 'submit',
                    'class'   => 'btn btn-primary btn-block rounded',
                    'content' => 'Change Password'
                ]); ?>
            </div>
        <?= form_close() ?>
    </div>
</div>