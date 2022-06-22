<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="form-head dashboard-head d-md-flex d-block mb-5 align-items-start">
            <h2 class="dashboard-title"><?= $operation ?></h2>
        </div>
        <div class="card">
            <div class="card-body py-0 pt-2">
                <?= form_open() ?>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <?= form_label('Order Number', '', 'class="col-form-label"') ?>
                                <?= form_input([
                                    'class' => "form-control solid",
                                    'disabled' => '',
                                    'value' => $data->or_id
                                ]); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?= form_label("Total", '', 'class="col-form-label"') ?>
                                <?= form_input([
                                    'class' => "form-control solid",
                                    'disabled' => '',
                                    'value' => "₹ $data->total"
                                ]); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?= form_label("Discount (In %)", '', 'class="col-form-label"') ?>
                                <?= form_input([
                                    'class' => "form-control solid",
                                    'name' => 'discount',
                                    'id' => 'discount',
                                    'onchange' => 'getDiscount(this.value)',
                                    'value' => set_value('discount') ? set_value('discount') : 0
                                ]); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?= form_label("Final Total", 'final_total', 'class="col-form-label"') ?>
                                <?= form_input([
                                    'class' => "form-control solid",
                                    'name' => 'final_total',
                                    'id' => 'final_total',
                                    'value' => set_value('final_total') ? set_value('final_total') : $data->total
                                ]); ?>
                                <?= form_error('final_total') ?>
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

<script>
    const getDiscount = (discount) => {
        let total = parseInt(<?= $data->total ?>);
        document.getElementById('final_total').value = Math.ceil((total * (100 - discount)) / 100);
    }

    getDiscount(document.getElementById('discount').value);
</script>