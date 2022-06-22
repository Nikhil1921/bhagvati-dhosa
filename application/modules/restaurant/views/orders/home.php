<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="form-head dashboard-head d-md-flex d-block mb-3 align-items-start">
            <h2 class="dashboard-title me-auto"><?= $title ?> <?= $operation ?></h2>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="datatables display mb-4 defaultTable dataTablesCard">
                        <thead>
                            <tr>
                                <th class="target">SR. NO.</th>
                                <th>ORDER NO</th>
                                <th>DATE TIME</th>
                                <th>PAY STATUS</th>
                                <?php if($this->user->role !== 'Shef'): ?>
                                <th>DISCOUNT</th>
                                <th>TOTAL</th>
                                <?php endif ?>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>