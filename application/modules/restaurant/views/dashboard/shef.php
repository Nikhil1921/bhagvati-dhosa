<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- <label class="toggle mb-4" for="myToggle">
            Click for running orders
            <input class="toggle__input" name="" type="checkbox" id="myToggle" onclick="window.location.href = '<?= base_url(admin('dashboard?status='.($this->input->get('status') === '1' ? 0 : 1))) ?>';" <?= $this->input->get('status') === '1' ? "checked" : '' ?>>
            <div class="toggle__fill"></div>
        </label> -->
        <div class="row">
            
            <?php if($orders): ?>
            <h1 class="alert alert-primary text-center">Pending orders</h1>
            <?php foreach($orders as $order): if($order->status !== 'Ongoing') break; ?>
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
                        <h3 class="text-white">
                        </h3>
                    </div>
                    <div class="card-body">
                        <ul class="order-list">
                            <?php array_walk_recursive($order->items, function($item){
                                
                                if($item->pending_qty === '0')
                                    echo "";
                                    /* echo  "<div class='row'>
                                                <div class='col-7'><del><span>$item->qty</span>$item->i_name<br /><span>$item->remarks</span></del></div>
                                                <div class='col-1'><del><span>$item->pending_qty</span></del></div>
                                                <div class='col-1'>
                                                    <span class='deliver-btn'>D</span>
                                                </div>
                                            </div>"; */
                                else{
                                    echo '<li>';
                                    echo  "<div class='row'>
                                                <div class='col-7'><span>$item->qty</span>$item->i_name<br /><span>$item->remarks</span></div>
                                                <div class='col-1'><span>$item->pending_qty</span></div>
                                                <div class='col-3'>
                                                    <div class='row'>
                                                        <div class='col-6'><span class='".($item->pending_qty !== $item->qty ? 'running' : 'pending')."-btn'>".($item->pending_qty !== $item->qty ? 'P' : 'P')."</span></div>
                                                        <div class='col-6'>
                                                            ".form_open(admin('deliver-item'), 'id="item-deliver-'.e_id($item->id).'"')."
                                                            ".form_hidden('id', e_id($item->id))."
                                                            <span class='minus-btn' onclick='document.getElementById(\"item-deliver-".e_id($item->id)."\").submit()'>-</span>
                                                            ".form_close()."
                                                        </div>
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
            <?php endforeach; ?>
            <h1 class="alert alert-primary text-center">Running orders</h1>
            <?php foreach($orders as $order): if($order->status === 'Ongoing') continue; ?>
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
                        <h3 class="text-white">
                        </h3>
                    </div>
                    <div class="card-body">
                        <ul class="order-list">
                            <?php $count = array_sum(array_map(function($i){ return $i->pending_qty; }, $order->items)); 
                            array_walk_recursive($order->items, function($item) use ($count) {
                                echo '<li>';
                                if($item->pending_qty === '0')
                                    echo  $count === 0 ?  "<div class='row'>
                                                <div class='col-7'><del><span>$item->qty</span>$item->i_name<br /><span>$item->remarks</span></del></div>
                                                <div class='col-1'><del><span>$item->pending_qty</span></del></div>
                                                <div class='col-1'>
                                                    <span class='deliver-btn'>D</span>
                                                </div>
                                            </div>" : "";
                                else
                                    echo  "<div class='row'>
                                                <div class='col-7'><span>$item->qty</span>$item->i_name<br /><span>$item->remarks</span></div>
                                                <div class='col-1'><span>$item->pending_qty</span></div>
                                                <div class='col-3'>
                                                    <div class='row'>
                                                        <div class='col-6'><span class='".($item->pending_qty !== $item->qty ? 'running' : 'pending')."-btn'>".($item->pending_qty !== $item->qty ? 'P' : 'P')."</span></div>
                                                        <div class='col-6'>
                                                            ".form_open(admin('deliver-item'), 'id="item-deliver-'.e_id($item->id).'"')."
                                                            ".form_hidden('id', e_id($item->id))."
                                                            <span class='minus-btn' onclick='document.getElementById(\"item-deliver-".e_id($item->id)."\").submit()'>-</span>
                                                            ".form_close()."
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>";
                                echo '</li>';
                            }) ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php  else: ?>
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