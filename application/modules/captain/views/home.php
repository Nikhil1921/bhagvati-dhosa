<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <div class="container mt-5">
        <div class="row">
            <div class="col-xl-12">
                <div class="owl-carousel item-carousel">
                    <?php foreach($cats as $k => $cat): ?>
                    <div class="items" onclick="showItemList(<?= e_id($cat['id']) ?>);" >
                        <div class="item-box <?= $k === 0 ? 'active' : '' ?> item-box-check active-<?= e_id($cat['id']) ?>" data-class="<?= e_id($cat['id']) ?>">
                            <?= img('assets/images/favicon.png'); ?>
                            <h5 class="title mb-0"><?= $cat['c_name'] ?></h5>
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="h-100">
                    <div class="card rounded-0">
                        <div class="card-body p-0">
                            <table class="table text-black" width="100%">
                                <thead>
                                    <tr>
                                        <th>ITEM</th>
                                        <th>PRICE</th>
                                        <th>TYPE</th>
                                        <th>time</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="products-list" >
                                    <?php foreach($cats as $cat): if($cat['prods']): foreach($cat['prods'] as $item): ?>
                                    <input type="hidden" name="item-details-<?= e_id($item['id']) ?>" value="<?= $item['description'] ?>" />
                                    <tr class="<?= e_id($cat['id']) ?>">
                                        <td><span class="font-w500 text-center"><?= $item['i_name'] ?></span></td>
                                        <td>₹ <?= $item['i_price'] ?></td>
                                        <td><?= $item['special_item'] ?></td>
                                        <td><?= $item['wait_time'] ?></td>
                                        <td id="item-<?= e_id($item['id']) ?>">
                                            <a href="javascript:;" onclick="addItem('<?= e_id($item['id']) ?>');" class="btn btn-warning light btn-xs btn-rounded ms-1 d-inline-block"><i class="fa fa-plus"></i></a>
                                            <a href="javascript:;" onclick="viewItemDetails('item-details-<?= e_id($item['id']) ?>');" class="btn btn-danger light btn-xs btn-rounded ms-1 d-inline-block"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; else: ?>
                                    <tr class="<?= e_id($cat['id']) ?>">
                                        <td colspan="5" class="text-center"><span class="font-w500">No products available.</span></td>
                                    </tr>
                                    <?php endif; endforeach ?>
                                </tbody>
                                <tfoot id="place-order">
                                    <tr>
                                        <th colspan="5">
                                            <?= anchor(admin('cart'), 'Continue', 'class="btn btn-outline-warning light btn-rounded ms-1 d-inline-block col-3"'); ?>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
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