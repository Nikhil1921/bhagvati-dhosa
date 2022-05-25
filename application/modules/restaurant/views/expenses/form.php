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
                                <?= form_label('Expense Item', 'expense', 'class="col-form-label"') ?>
                                <?= form_input([
                                    'class' => "form-control solid",
                                    'id' => "expense",
                                    'name' => "expense",
                                    'maxlength' => 100,
                                    'required' => "",
                                    'value' => set_value('expense') ? set_value('expense') : (isset($data['expense']) ? $data['expense'] : '')
                                ]); ?>
                                <?= form_error('expense') ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= form_label('Expense price', 'price', 'class="col-form-label"') ?>
                                <?= form_input([
                                    'class' => "form-control solid",
                                    'id' => "price",
                                    'name' => "price",
                                    'maxlength' => 9,
                                    'required' => "",
                                    'value' => set_value('price') ? set_value('price') : (isset($data['price']) ? $data['price'] : '')
                                ]); ?>
                                <?= form_error('price') ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= form_label('Expense date', 'created_at', 'class="col-form-label"') ?>
                                <?= form_input([
                                    'class' => "form-control solid",
                                    'type' => 'date',
                                    'id' => "created_at",
                                    'name' => "created_at",
                                    'required' => "",
                                    'value' => set_value('created_at') ? set_value('created_at') : (isset($data['created_at']) ? date('Y-m-d', $data['created_at']) : '')
                                ]); ?>
                                <?= form_error('created_at') ?>
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