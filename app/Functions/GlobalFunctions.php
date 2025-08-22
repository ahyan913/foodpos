<?php
function admin_url($path = ''){

   return url(env("ADMIN_URI")."/".$path);
}

function image_url($path = ''){
    return url("api/images/".$path);
}

function product_url($path, $type = "src"){
    return image_url("$type/product/".$path);
}

function store_url($path, $type = "src"){
    return image_url("$type/store/".$path);
}

function menu_url($path, $type = "src"){
    return image_url("$type/menu/".$path);
}

function banner_url($path, $type = "src"){
    return image_url("$type/banner/".$path);
}


