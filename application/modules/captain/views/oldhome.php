<div class="row" id="products-list">
    <?php foreach($cats as $cat): if($cat['prods']): foreach($cat['prods'] as $prod): ?>
    <div class="col-xl-3 col-xxl-3 col-lg-3 col-md-12 col-sm-6 <?= e_id($cat['id']) ?>">
        <div class="card item-card">
            <div class="card-body p-0">
                <?= img('assets/images/product.jpg', '', 'class="img-fluid"'); ?>
                <div class="info">
                    <h5 class="name"><?= $prod['i_name'] ?></h5>
                    <h6 class="mb-0 price">
                        ₹ <?= $prod['i_price'] ?>
                    </h6>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; else: ?>
        <div class="col-12 <?= e_id($cat['id']) ?>">
            <div class="card item-card">
                <div class="card-body p-0">
                    <div class="info text-center">
                        <h5 class="name">No products available.</h5>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; endforeach ?>
</div>