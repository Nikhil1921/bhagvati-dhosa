<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="widget-card-1 card">
                            <div class="card-body">
                                <div class="media">
                                    <?= img('assets/images/food-icon/4.png', '', 'class="me-4" width="80"') ?>
                                    <div class="media-body">
                                        <h3 class="mb-sm-3 mb-2"><span class="text-primary counter ms-0"><?= $total['orders'] ?></span></h3>
                                        <p class="mb-0 text-black">Total Orders</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="widget-card-1 card">
                            <div class="card-body">
                                <div class="media">
                                    <?= img('assets/images/food-icon/2.png', '', 'class="me-4" width="80"') ?>
                                    <div class="media-body">
                                        <h3 class="mb-sm-3 mb-2">₹ <span class="text-primary counter ms-0"><?= $total['revenue'] ?></span></h3>
                                        <p class="mb-0 text-black">Revenue</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="widget-card-1 card">
                            <div class="card-body">
                                <div class="media">
                                    <?= img('assets/images/food-icon/3.png', '', 'class="me-4" width="80"') ?>
                                    <div class="media-body">
                                        <h3 class="mb-sm-3 mb-2"><span class="text-primary counter ms-0"><?= $total['items_sold'] ?></span></h3>
                                        <p class="mb-0 text-black">Items Sold</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>