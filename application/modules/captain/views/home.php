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
            
            <!-- <label class="toggle mb-4" for="myToggle">
                Click for running orders
                <input class="toggle__input" name="" type="checkbox" id="myToggle" onclick="window.location.href = '<?= base_url(admin('dashboard?status='.($this->input->get('status') === '1' ? 0 : 1))) ?>';" <?= $this->input->get('status') === '1' ? "checked" : '' ?>>
                <div class="toggle__fill"></div>
            </label> -->
            
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
                                            <?= $orders ? anchor(admin('add-order'), 'Add to order', 'class="btn btn-outline-warning light btn-rounded ms-1 d-inline-block col-lg-3 col-4"') : ''; ?>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="row">
                    <?php if($orders): foreach($orders as $order): ?>
                    <div class="card-container col-lg-4 col-md-6 col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-danger text-white">
                                <div>
                                    <h4 class="text-white">
                                        <?php 
                                        if($order->tables)
                                            foreach($order->tables as $table) 
                                                echo $table->t_name, "<br />";
                                        else echo "Parcel";  ?>
                                    </h4>
                                    <span class="fs-12 op9"><?= $order->or_id ?></span>
                                </div>
                                <?php if($order->count <= 0): ?>
                                <h3 class="text-white">
                                    <?= form_open(admin('cancel-order')) ?>
                                    <?= form_hidden('id', e_id($order->id)) ?>
                                    <?= form_button([
                                        'type'    => 'submit',
                                        'class'   => 'btn btn-success btn-block col-12 text-white',
                                        'content' => 'CANCEL'
                                    ]); ?>
                                    <?= form_close() ?>
                                </h3>
                                <?php endif ?>
                                <h3 class="text-white">
                                    <?= anchor(admin('change-table/'.e_id($order->id)), "Change Table", 'class="btn btn-success btn-block col-12 text-white"') ?>
                                </h3>
                            </div>
                            <div class="card-body">
                                <ul class="order-list">
                                    <?php array_walk_recursive($order->items, function($item){
                                        
                                        if($item->pending_qty === '0') echo "";
                                            /* echo  "<div class='row'>
                                                        <div class='col-7'><del><span>$item->qty</span>$item->i_name<br /><span>$item->remarks</span></del></div>
                                                        <div class='col-1'><del><span>$item->pending_qty</span></del></div>
                                                        <div class='col-3'>
                                                            <span class='deliver-btn'>D</span>
                                                        </div>
                                                    </div>"; */
                                        else
                                        {
                                            echo '<li>';
                                            echo  "<div class='row'>
                                                        <div class='col-7'><span>$item->qty</span>$item->i_name<br /><span>$item->remarks</span></div>
                                                        <div class='col-1'><span>$item->pending_qty</span></div>
                                                        <div class='col-3'>
                                                            <div class='row'>
                                                                <div class='col-6'><span class='".($item->pending_qty !== $item->qty ? 'running' : 'pending')."-btn'>".($item->pending_qty !== $item->qty ? 'P' : 'P')."</span></div>
                                                                ".($item->pending_qty === $item->qty ? "<div class='col-6'>
                                                                    ".form_open(admin('cancel-item'), 'id="item-cancel-'.e_id($item->id).'"')."
                                                                    ".form_hidden('id', e_id($item->id))."
                                                                    <span class='minus-btn' onclick='document.getElementById(\"item-cancel-".e_id($item->id)."\").submit()'>-</span>
                                                                    ".form_close()."
                                                                </div>" : '')."
                                                            </div>
                                                        </div>
                                                    </div>";
                                            echo '</li>';
                                        }
                                    }) ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; else: ?>
                        <div class="card-container col-lg-4 col-md-6 col-12">
                            <div class="card shadow-sm">
                                <div class="card-header bg-danger text-white">
                                    <div>
                                        <h4 class="text-white">Hello</h4>
                                        <span class="fs-12 op9"><?= $this->user->name ?></span>
                                    </div>
                                    <h3 class="text-white"></h3>
                                </div>
                                <div class="card-body">
                                    <ul class="order-list">
                                        <li>No current orders are available.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
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