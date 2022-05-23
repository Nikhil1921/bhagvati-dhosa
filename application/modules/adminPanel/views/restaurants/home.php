<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="form-head dashboard-head d-md-flex d-block mb-5 align-items-start">
            <h2 class="dashboard-title me-auto"><?= $title ?> <?= $operation ?></h2>
            <?= anchor("$url/add-update", '<span class="fa fa-plus"></span> Add new', 'class="btn btn-outline-success btn-rounded text-center col-md-2 col-3 float-right"'); ?>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="datatables display mb-4 defaultTable dataTablesCard" style="min-width: 845px;">
                        <thead>
                            <tr>
                                <th class="target">SR. NO.</th>
                                <th>NAME</th>
                                <th>CONTACT PERSON</th>
                                <th>MOBILE</th>
                                <th>EMAIL</th>
                                <th class="target">ACTION</th>
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