<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-md-8 col-12"><h2 class="dashboard-title me-auto"><?= $title ?> <?= $operation ?></h2></div>
            <div class="col-md-<?= verify_access($name, 'add_update') ? 2 : 4 ?> col-6">
                <select name="status" class="form-control">
                    <option value="">Select Category</option>
                    <?php foreach($this->cats as $cat): ?>
                        <option value="<?= e_id($cat['id']) ?>"><?= $cat['c_name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="col-md-2 col-6">
                <?= verify_access($name, 'add_update') ? anchor("$url/add-update", '<span class="fa fa-plus"></span> Add new', 'class="btn btn-outline-success btn-rounded text-center col-12 float-right"') : ''; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="datatables display mb-4 defaultTable dataTablesCard">
                        <thead>
                            <tr>
                                <th class="target">SR. NO.</th>
                                <th>NAME</th>
                                <th>PRICE</th>
                                <th>CATEGORY</th>
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