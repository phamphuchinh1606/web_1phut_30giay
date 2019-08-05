<?php

Breadcrumbs::for('admin.home', function ($trail) {
    $trail->push('Trang Chủ', route('admin.home'));
});

//Product
Breadcrumbs::for('admin.product', function ($trail) {
    $trail->parent('admin.home');
    $trail->push('Sản phẩm', route('admin.product.index'));
});

//Product Crate
Breadcrumbs::for('admin.product.create', function ($trail) {
    $trail->parent('admin.product');
    $trail->push('Tạo mới sản phẩm');
});

//Product Crate
Breadcrumbs::for('admin.product.edit', function ($trail, $productName) {
    $trail->parent('admin.product');
    $trail->push($productName);
});
