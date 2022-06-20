<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <div class="container mt-5">
        <div class="card">
            <div class="card-body py-0 pt-2">
                <h5 class="mt-4">Select table(s) to change</h5>
                <?= form_open() ?>
                    <div class="row">
                        <?php foreach ($tables as $v): ?>
                            <div class="col-2 form-check custom-checkbox mt-3">
                                <?= form_checkbox([
                                    'class' => "form-check-input",
                                    'id' => "table-".e_id($v['id']),
                                    'name' => "tables[]",
                                    'value' => e_id($v['id']),
                                    'checked' => set_checkbox('tables[]', e_id($v['id']))
                                ]); ?>
                                <label class="form-check-label" for="table-<?= e_id($v['id']) ?>"><?= $v['t_name'] ?></label>
                            </div>
                        <?php endforeach ?>
                        <div class="col-12 mt-2">
                            <?= form_error('tables[]') ?>
                        </div>
                        <div class="col-12"></div>
                        <div class="col-6 col-md-3 pb-3 pt-3">
                            <?= form_button([
                                'type'    => 'submit',
                                'class'   => 'btn btn-outline-warning light btn-rounded ms-1 d-inline-block col-12',
                                'content' => 'Change table(s)'
                            ]); ?>
                        </div>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>