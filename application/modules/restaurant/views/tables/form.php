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
                                <?= form_label('Table name', 't_name', 'class="col-form-label"') ?>
                                <?= form_input([
                                    'class' => "form-control solid",
                                    'id' => "t_name",
                                    'name' => "t_name",
                                    'maxlength' => 100,
                                    'required' => "",
                                    'value' => set_value('t_name') ? set_value('t_name') : (isset($data['t_name']) ? $data['t_name'] : '')
                                ]); ?>
                                <?= form_error('t_name') ?>
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