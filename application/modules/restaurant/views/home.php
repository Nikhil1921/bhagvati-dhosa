<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row order-row" id="masonry">
            <?php if($orders): foreach($orders as $order): ?>
            <div class="card-container">
                <div class="card shadow-sm">
                    <div class="card-header bg-danger text-white">
                        <div>
                            <h4 class="text-white">
                                <?php foreach($order->tables as $table) echo $table->t_name, "<br />"; ?>
                            </h4>
                            <span class="fs-12 op9"><?= $order->or_id ?></span>
                        </div>
                        <h3 class="text-white"><?= date('h:i', strtotime($order->created_time)) ?></h3>
                    </div>
                    <div class="card-body">
                        <ul class="order-list">
                            <?php array_walk_recursive($order->items, function($item){
                                echo '<li>';

                                if($item->pending_qty === '0')
                                    echo "<del><span>$item->qty</span>$item->i_name</del>";
                                else{
                                    echo  "<div class='row'>
                                                <div class='col-9'><span>$item->qty</span>$item->i_name</div>
                                                <div class='col-1'><span>$item->pending_qty</span></div>
                                                <div class='col-1'>
                                                    <span class='minus-btn' onclick='alert(".e_id($item->id).")'>-</span>
                                                </div>
                                            </div>";
                                }
                                
                                echo '</li>';
                            }) ?>
                            <?php foreach($order->items as $item): ?>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endforeach; else: ?>
                <div class="card-container">
                    <div class="card shadow-sm">
                        <div class="card-header bg-danger text-white">
                            <div>
                                <h4 class="text-white">Hello</h4>
                                <span class="fs-12 op9"><?= $this->user->name ?></span>
                            </div>
                            <h3 class="text-white"><?= date('h:i') ?></h3>
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