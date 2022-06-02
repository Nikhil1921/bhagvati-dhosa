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
                                <?= form_label('Category', 'c_id', 'class="col-form-label"') ?>
                                <select name="c_id" id="c_id" class="form-control solid">
                                    <option value="">Select Category</option>
                                    <?php foreach($this->cats as $cat): ?>
                                        <option value="<?= e_id($cat['id']) ?>" <?= set_value('c_id') ? set_select('c_id', e_id($cat['id'])) : (isset($data['c_id']) && $data['c_id'] === $cat['id'] ? 'selected' : '') ?>><?= $cat['c_name'] ?></option>
                                    <?php endforeach ?> 
                                </select>
                                <?= form_error('c_id') ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= form_label('Item name', 'i_name', 'class="col-form-label"') ?>
                                <?= form_input([
                                    'class' => "form-control solid",
                                    'id' => "i_name",
                                    'name' => "i_name",
                                    'maxlength' => 100,
                                    'required' => "",
                                    'value' => set_value('i_name') ? set_value('i_name') : (isset($data['i_name']) ? $data['i_name'] : '')
                                ]); ?>
                                <?= form_error('i_name') ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= form_label('Item price', 'i_price', 'class="col-form-label"') ?>
                                <?= form_input([
                                    'class' => "form-control solid",
                                    'id' => "i_price",
                                    'name' => "i_price",
                                    'maxlength' => 5,
                                    'required' => "",
                                    'value' => set_value('i_price') ? set_value('i_price') : (isset($data['i_price']) ? $data['i_price'] : '')
                                ]); ?>
                                <?= form_error('i_price') ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <?= form_label('Special item', 'special_item', 'class="col-form-label"') ?>
                            <div class="form-check custom-checkbox mt-3">
                                <?= form_checkbox([
                                    'class' => "form-check-input",
                                    'id' => "special_item",
                                    'name' => "special_item",
                                    'value' => 1,
                                    'checked' => set_value('special_item') ? set_checkbox('special_item', 1) : (isset($data['special_item']) ? $data['special_item'] : false)
                                ]); ?>
                                <label class="form-check-label" for="special_item">Is special item?</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= form_label('Waiting Time', 'wait_time', 'class="col-form-label"') ?>
                                <?= form_input([
                                    'class' => "form-control solid",
                                    'id' => "wait_time",
                                    'name' => "wait_time",
                                    'maxlength' => 2,
                                    'required' => "",
                                    'value' => set_value('wait_time') ? set_value('wait_time') : (isset($data['wait_time']) ? $data['wait_time'] : '')
                                ]); ?>
                                <?= form_error('wait_time') ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <?= form_label('Item description', 'description', 'class="col-form-label"') ?>
                                <?= form_textarea([
                                    'class' => "form-control solid",
                                    'id' => "description",
                                    'name' => "description",
                                    'required' => "",
                                    'value' => set_value('description') ? set_value('description') : (isset($data['description']) ? $data['description'] : '')
                                ]); ?>
                                <?= form_error('description') ?>
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