<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="form-head dashboard-head d-md-flex d-block mb-5 align-items-start">
            <h2 class="dashboard-title"><?= $operation ?> <?= $title ?></h2>
        </div>
        <div class="card">
            <div class="card-body py-0 pt-2">
                <?= form_open() ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= form_label('Name', 'name', 'class="col-form-label"') ?>
                                <?= form_input([
                                    'class' => "form-control solid",
                                    'id' => "name",
                                    'name' => "name",
                                    'maxlength' => 100,
                                    'required' => "",
                                    'value' => set_value('name') ? set_value('name') : (isset($data['name']) ? $data['name'] : '')
                                ]); ?>
                                <?= form_error('name') ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= form_label('Mobile', 'mobile', 'class="col-form-label"') ?>
                                <?= form_input([
                                    'class' => "form-control solid",
                                    'id' => "mobile",
                                    'name' => "mobile",
                                    'maxlength' => 10,
                                    'required' => "",
                                    'value' => set_value('mobile') ? set_value('mobile') : (isset($data['mobile']) ? $data['mobile'] : '')
                                ]); ?>
                                <?= form_error('mobile') ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= form_label('Email', 'email', 'class="col-form-label"') ?>
                                <?= form_input([
                                    'class' => "form-control solid",
                                    'id' => "email",
                                    'type' => "email",
                                    'name' => "email",
                                    'maxlength' => 100,
                                    'required' => "",
                                    'value' => set_value('email') ? set_value('email') : (isset($data['email']) ? $data['email'] : '')
                                ]); ?>
                                <?= form_error('email') ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= form_label('Password', 'password', 'class="col-form-label"') ?>
                                <?= form_input([
                                    'class' => "form-control solid",
                                    'id' => "password",
                                    'name' => "password",
                                    'type' => "password",
                                    'maxlength' => 100,
                                    isset($data['password']) ? 'required' : '',
                                ]); ?>
                                <?= form_error('password') ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <?= form_label('Role', '', 'class="col-form-label"') ?>
                            <br>
                            <?php foreach (roles() as $k => $role): ?>
                                <?= form_label(form_radio([
                                    'class' => "form-check-input",
                                    'name'  => 'role'
                                ], $role, set_value('role') ? set_radio('role', $role) : (isset($data['role']) && $data['role'] === $role ? true : (array_key_first(roles()) === $k ? true : false) ))." $role", '', 'class="form-check-label radio-inline"') ?>
                            <?php endforeach ?>
                        </div>
                        <div class="col-12"></div>
                        <div class="col-6 col-md-3 pb-3">
                            <?= form_button([
                                'type'    => 'submit',
                                'class'   => 'btn btn-outline-primary btn-block col-12',
                                'content' => 'SAVE'
                            ]); ?>
                        </div>
                        <div class="col-6 col-md-3">
                            <?= anchor("$url", 'CANCEL', 'class="btn btn-outline-danger col-12"'); ?>
                        </div>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>