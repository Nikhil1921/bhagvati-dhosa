<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <?php if($orders): foreach($orders as $order): ?>
            <div class="card-container col-lg-4 col-md-6 col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-danger text-white">
                        <div>
                            <h4 class="text-white">
                                <?php foreach($order->tables as $table) echo $table->t_name, "<br />"; ?>
                            </h4>
                            <span class="fs-12 op9"><?= $order->or_id ?></span>
                        </div>
                        <h3 class="text-white">
                        </h3>
                    </div>
                    <div class="card-body">
                        <ul class="order-list">
                            <?php array_walk_recursive($order->items, function($item){
                                echo '<li>';
                                if($item->pending_qty === '0')
                                    echo  "<div class='row'>
                                                <div class='col-9'><del><span>$item->qty</span>$item->i_name<span>$item->remarks</span></del></div>
                                                <div class='col-1'><del><span>$item->pending_qty</span></del></div>
                                                <div class='col-1'>
                                                    <span class='deliver-btn'>D</span>
                                                </div>
                                            </div>";
                                else
                                    echo  "<div class='row'>
                                                <div class='col-9'><span>$item->qty</span>$item->i_name<span>$item->remarks</span></div>
                                                <div class='col-1'><span>$item->pending_qty</span></div>
                                                <div class='col-1'>
                                                    <span class='pending-btn'>P</span>
                                                </div>
                                            </div>";
                                
                                echo '</li>';
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