<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= APP_NAME ?> Invoice</title>
        <?= link_tag('assets/back/invoice/style.css', 'stylesheet', 'text/css') ?>
    </head>
    <body>
        <div class="cs-container">
            <div class="cs-invoice cs-style1">
                <div class="cs-invoice_in" id="download_section">
                    <div class="cs-invoice_head cs-type1 cs-mb25">
                        <div class="cs-invoice_left">
                            <p class="cs-invoice_number cs-primary_color cs-mb5 cs-f16"><b class="cs-primary_color">Invoice No:</b> #BD<?= $data->or_id ?></p>
                            <p class="cs-invoice_date cs-primary_color cs-m0"><b class="cs-primary_color">Date: </b><?= date('d.m.Y', strtotime($data->created_date)) ?></p>
                        </div>
                        <div class="cs-invoice_right cs-text_right">
                            <h4 class="cs-logo cs-mb5"><strong><?= APP_NAME ?></strong></h4>
                        </div>
                    </div>
                    <div class="cs-table cs-style1">
                    <div class="cs-round_border">
                        <div class="cs-table_responsive">
                        <table>
                            <thead>
                            <tr>
                                <th class="cs-width_1 cs-semi_bold cs-primary_color cs-focus_bg">SR #</th>
                                <th class="cs-width_4 cs-semi_bold cs-primary_color cs-focus_bg">Item</th>
                                <th class="cs-width_2 cs-semi_bold cs-primary_color cs-focus_bg">Qty</th>
                                <th class="cs-width_2 cs-semi_bold cs-primary_color cs-focus_bg">Price</th>
                                <th class="cs-width_2 cs-semi_bold cs-primary_color cs-focus_bg cs-text_right">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $total = 0; foreach($data->items as $k => $item): $total += $item->price * $item->qty ?>
                            <tr>
                                <td class="cs-width_1"><?= ++$k ?></td>
                                <td class="cs-width_4"><?= $item->i_name ?></td>
                                <td class="cs-width_2"><?= $item->qty ?></td>
                                <td class="cs-width_2">₹ <?= $item->price ?></td>
                                <td class="cs-width_2 cs-text_right">₹ <?= $item->price * $item->qty ?></td>
                            </tr>
                            <?php endforeach ?>
                            </tbody>
                        </table>
                        </div>
                        <div class="cs-invoice_footer cs-border_top">
                        <div class="cs-left_footer cs-mobile_hide"></div>
                        <div class="cs-right_footer">
                            <table>
                                <tbody>
                                    <tr class="cs-border_left">
                                    <td class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">Subtoal</td>
                                    <td class="cs-width_3 cs-semi_bold cs-focus_bg cs-primary_color cs-text_right">₹ <?= $total ?></td>
                                    </tr>
                                    <tr class="cs-border_left">
                                    <td class="cs-width_3 cs-semi_bold cs-primary_color cs-focus_bg">Discount</td>
                                    <td class="cs-width_3 cs-semi_bold cs-focus_bg cs-primary_color cs-text_right"><?= $total - $data->final_total ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    <div class="cs-invoice_footer">
                        <div class="cs-left_footer cs-mobile_hide"></div>
                            <div class="cs-right_footer">
                                <table>
                                    <tbody>
                                        <tr class="cs-border_none">
                                            <td class="cs-width_3 cs-border_top_0 cs-bold cs-f16 cs-primary_color">Total Amount</td>
                                            <td class="cs-width_3 cs-border_top_0 cs-bold cs-f16 cs-primary_color cs-text_right">₹ <?= $data->final_total ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cs-invoice_btns cs-hide_print">
                    <a href="javascript:window.print()" class="cs-invoice_btn cs-color1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><circle cx="392" cy="184" r="24"/></svg>
                        <span>Print</span>
                    </a>
                    <?= anchor(admin('dashboard'), '<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 219.151 219.151" style="enable-background:new 0 0 219.151 219.151;" xml:space="preserve"><g><path d="M109.576,219.151c60.419,0,109.573-49.156,109.573-109.576C219.149,49.156,169.995,0,109.576,0S0.002,49.156,0.002,109.575C0.002,169.995,49.157,219.151,109.576,219.151z M109.576,15c52.148,0,94.573,42.426,94.574,94.575c0,52.149-42.425,94.575-94.574,94.576c-52.148-0.001-94.573-42.427-94.573-94.577C15.003,57.427,57.428,15,109.576,15z"/><path d="M94.861,156.507c2.929,2.928,7.678,2.927,10.606,0c2.93-2.93,2.93-7.678-0.001-10.608l-28.82-28.819l83.457-0.008c4.142-0.001,7.499-3.358,7.499-7.502c-0.001-4.142-3.358-7.498-7.5-7.498l-83.46,0.008l28.827-28.825c2.929-2.929,2.929-7.679,0-10.607c-1.465-1.464-3.384-2.197-5.304-2.197c-1.919,0-3.838,0.733-5.303,2.196l-41.629,41.628c-1.407,1.406-2.197,3.313-2.197,5.303c0.001,1.99,0.791,3.896,2.198,5.305L94.861,156.507z"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>Back', 'class="cs-invoice_btn cs-color2"') ?>
                </div>
            </div>
        </div>
    </body>
</html>