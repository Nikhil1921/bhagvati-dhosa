<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <div class="container mt-5">
        <div class="row">
            <div class="col-xl-12">
                <div class="h-100">
                    <div class="card rounded-0">
                        <div class="card-body p-0">
                            <table class="table text-black" width="100%">
                                <thead>
                                    <tr>
                                        <th>ITEM</th>
                                        <th>remarks</th>
                                        <th>PRICE</th>
                                        <th>TYPE</th>
                                        <th>time</th>
                                        <th>quantity</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="products-list">
                                    <?php if($cart): foreach($cart as $item): ?>
                                    <input type="hidden" name="item-details-<?= e_id($item['id']) ?>" value="<?= $item['description'] ?>" />
                                    <tr id="remove-<?= e_id($item['id']) ?>">
                                        <td>
                                            <span class="font-w500 text-center"><?= $item['i_name'] ?></span><br>
                                            <span class="font-w500 text-center" id="item-remarks-<?= e_id($item['id']) ?>"><?= $item['remarks'] ?></span>
                                        </td>
                                        <td>
                                            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#addRemarksModal" onclick="checkRemarks('<?= e_id($item['id']) ?>');" class="btn btn-danger light btn-xs btn-rounded ms-1 d-inline-block"><i class="fa fa-edit"></i></a>
                                        </td>
                                        <td>₹ <?= $item['i_price'] ?></td>
                                        <td><?= $item['special_item'] ?></td>
                                        <td><?= $item['wait_time'] ?></td>
                                        <td><?= $item['qty'] ?></td>
                                        <td id="item-<?= e_id($item['id']) ?>"></td>
                                    </tr>
                                    <?php endforeach; else: ?>
                                    <tr class="">
                                        <td colspan="7" class="text-center"><span class="font-w500">No products available.</span></td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" id="place-order">
            <div class="card-body py-0 pt-2">
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
                                'content' => 'Place order'
                            ]); ?>
                        </div>
                        <div class="col-6 col-md-3 pb-3 pt-3">
                            <?= anchor(admin('parcel-order'), 'Parcel order', ['class'   => 'btn btn-outline-primary light btn-rounded ms-1 d-inline-block col-12']); ?>
                        </div>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="itemDetailsModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p id="item-details"></p>
                <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addRemarksModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Remarks</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="item-id" value="" />
                <textarea id="remarks" cols="30" rows="10" class="form-control solid" maxlength="100"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="addRemarks();" class="btn btn-danger light">Save changes</button>
            </div>
        </div>
    </div>
</div>