<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en" class="h-100">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= ucwords($title) ?> | <?= APP_NAME ?></title>
        <?= link_tag('assets/images/favicon.png', 'icon', 'image/png') ?>
        <?= link_tag('assets/back/css/style.css', 'stylesheet', 'text/css') ?>
    </head>
    <body class="h-100">
        <?= $contents ?>
    </body>
</html>