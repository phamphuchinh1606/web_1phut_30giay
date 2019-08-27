<?php

namespace App\Common;

class Constant{
    public const AUTH_GUARD_EMPLOYEE = "employee";

    public const DELETE_FLG_ON = 1;
    public const DELETE_FLG_OFF = 0;

    public const EMPLOYEE_SALE_CARD_SMALL = 1;

    public const SWITCH_FLG_ON = "on";
    public const SWITCH_FLG_OFF = "off";

    public static $PUBLIC_PRODUCT_SERVICE = 1;
    public static $PUBLIC_PRODUCT = 0;

    public static $PUBLIC_FLG_ON = 1;
    public static $PUBLIC_FLG_ON_NAME = "Công khai";
    public static $PUBLIC_FLG_OFF = 0;
    public static $PUBLIC_FLG_OFF_NAME = "Không công khai";

    public static $STATUS_READ_ON = 1;
    public static $STATUS_READ_ON_NAME = "Đã đọc";
    public static $STATUS_READ_OFF = 0;
    public static $STATUS_READ_OFF_NAME = "Chưa đọc";

    public static $TAG_KEY_ONE = 1;
    public static $TAG_KEY_TWO = 2;

    public static $PATH_FOLDER_PUBLIC = "";
    public static $PATH_FOLDER_UPLOAD_IMAGE_EDITOR = "images_editor";
    public static $PATH_FOLDER_UPLOAD_IMAGE_DROP = "images_drop";
    public static $PATH_FOLDER_UPLOAD_PRODUCT = "products";
    public static $PATH_FOLDER_UPLOAD_PRODUCT_TYPE = "product_types";
    public static $PATH_URL_UPLOAD_IMAGE = "storage/";
//    public static $PATH_URL_UPLOAD_IMAGE = "storage/";
    public static $PATH_FOLDER_UPLOAD_IMAGE_BANNER = "banners";
    public static $PATH_FOLDER_UPLOAD_IMAGE_TOP_BANNER = 'top_banners';
    public static $PATH_FOLDER_UPLOAD_IMAGE_BLOG = "blogs";
    public static $PATH_FOLDER_UPLOAD_IMAGE_MANUFACTURE = 'manufactures';
    public static $PATH_FOLDER_UPLOAD_IMAGE_ALBUM = "albums";

    public static $SORT_BY_PRODUCT_CREATED_DESCENDING = 'created-descending';
    public static $SORT_BY_PRODUCT_CREATED_ASCENDING = 'created-ascending';
    public static $SORT_BY_PRODUCT_PRICE_ASCENDING = 'price-ascending';
    public static $SORT_BY_PRODUCT_PRICE_DESCENDING = 'price-descending';
    public static $SORT_BY_PRODUCT_TITLE_ASCENDING = 'title-ascending';
    public static $SORT_BY_PRODUCT_TITLE_DESCENDING = 'title-ascending';
    public static $SORT_BY_PRODUCT_BEST_SELLING = 'best-selling';

    public static $ORDER_STATUS_NEW_CODE = '0';
    public static $ORDER_STATUS_NEW_NAME = 'Chưa xác nhân';
    public static $ORDER_STATUS_CONFIRM_CODE = '1';
    public static $ORDER_STATUS_CONFIRM_NAME = 'Đã xác nhận';
    public static $ORDER_STATUS_SHIPPING_CODE = '2';
    public static $ORDER_STATUS_SHIPPING_NAME = 'Đang giao hàng';
    public static $ORDER_STATUS_FINISH_CODE = '3';
    public static $ORDER_STATUS_FINISH_NAME = 'Đã hoàn thành';
    public static $ORDER_STATUS_CANCEL_CODE = '4';
    public static $ORDER_STATUS_CANCEL_NAME = 'Đã hủy';

    public static $FEATURE_TYPE_OPERATE = "1";
    public static $FEATURE_TYPE_SAFE = "2";

//    Blog
    public static $BLOG_TYPE_GENERAL_ID = '1';
    public static $BLOG_TYPE_GENERAL_NAME = 'Tin tức chung';
    public static $BLOG_TYPE_PROMOTION_ID = '2';
    public static $BLOG_TYPE_PROMOTION_NAME = 'Khuyến mãi';
    public static $BLOG_TYPE_EVENT_ID = '3';
    public static $BLOG_TYPE_EVENT_NAME = 'Sự kiện';

//    Product
    public static $PRODUCT_IMAGE_TYPE_IMAGE = '0';
    public static $PRODUCT_IMAGE_TYPE_FURNITURE = '1';
    public static $PRODUCT_IMAGE_TYPE_EXTERIOR = '2';

    public static $URL_TOYOTA = "http://www.toyota.com.vn";

}
