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
                                <?= form_label('Restaurant name', 'name', 'class="col-form-label"') ?>
                                <?= form_input([
                                    'class' => "form-control",
                                    'id' => "name",
                                    'name' => "name",
                                    'maxlength' => 255,
                                    'required' => "",
                                    'value' => set_value('name') ? set_value('name') : (isset($data['name']) ? $data['name'] : '')
                                ]); ?>
                                <?= form_error('name') ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= form_label('Contact person', 'c_name', 'class="col-form-label"') ?>
                                <?= form_input([
                                    'class' => "form-control",
                                    'id' => "c_name",
                                    'name' => "c_name",
                                    'maxlength' => 100,
                                    'required' => "",
                                    'value' => set_value('c_name') ? set_value('c_name') : (isset($data['c_name']) ? $data['c_name'] : '')
                                ]); ?>
                                <?= form_error('c_name') ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= form_label('Mobile', 'mobile', 'class="col-form-label"') ?>
                                <?= form_input([
                                    'class' => "form-control",
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
                                <?= form_label('Password', 'password', 'class="col-form-label"') ?>
                                <?= form_input([
                                    'class' => "form-control",
                                    'id' => "password",
                                    'name' => "password",
                                    'maxlength' => 100,
                                    isset($data['password']) ? 'required' : '',
                                ]); ?>
                                <?= form_error('password') ?>
                            </div>
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