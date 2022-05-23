<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="form-head dashboard-head d-md-flex d-block mb-5 align-items-start"></div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <div class="authincation h-100">
                        <div class="container h-100">
                            <div class="row justify-content-center h-100 align-items-center">
                                <div class="col-md-12">
                                    <div class="form-input-content text-center error-page">
                                        <h1 class="error-text font-weight-bold">404</h1>
                                        <h4><i class="fa fa-exclamation-triangle text-warning"></i> The page you were looking for is not found!</h4>
                                        <p>You may have mistyped the address or the page may have moved.</p>
                                        <div>
                                            <?= anchor(admin(), 'Back to Home', 'class="btn btn-primary"') ?>
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
</div>