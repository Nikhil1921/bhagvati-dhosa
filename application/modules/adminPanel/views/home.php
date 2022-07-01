<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="widget-card-1 card">
                            <div class="card-body">
                                <div class="media">
                                    <?= img('assets/images/food-icon/package.png', '', 'class="me-4" width="80"') ?>
                                    <div class="media-body">
                                        <h3 class="mb-sm-3 mb-2"><span class="text-primary counter ms-0"><?= $total['orders'] ?></span></h3>
                                        <p class="mb-0 text-black">Total Orders</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="widget-card-1 card">
                            <div class="card-body">
                                <div class="media">
                                    <?= img('assets/images/food-icon/revenue.png', '', 'class="me-4" width="80"') ?>
                                    <div class="media-body">
                                        <h3 class="mb-sm-3 mb-2">₹ <span class="text-primary counter ms-0"><?= $total['revenue'] ?></span></h3>
                                        <p class="mb-0 text-black">Total Revenue</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="widget-card-1 card">
                            <div class="card-body">
                                <div class="media">
                                    <?= img('assets/images/food-icon/masala-dosa.png', '', 'class="me-4" width="80"') ?>
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
            <div class="col-xl-12">
                <div id="user-activity" class="card">
                    <div class="card-header border-0 pb-0 d-sm-flex d-block">
                        <div>
                            <h2 class="main-title mb-1">Earnings</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="user" role="tabpanel">
                                <canvas id="activity" class="chartjs"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>