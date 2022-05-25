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
                                        <h1 class="error-text font-weight-bold">403</h1>
                                        <h4><i class="fa fa-exclamation-triangle text-warning"></i> you are not permitted to access this module!</h4>
                                        <p>You have to get permission from admin to access it.</p>
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