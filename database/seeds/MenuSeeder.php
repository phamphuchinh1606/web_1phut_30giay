<?php

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arraySuppliers = [
            [
                'menu_id' => 'home',
                'menu_name' => 'Trang Chủ',
                'menu_url' => '/admin',
                'parent_menu_id' => null,
                'is_show' => 1,
                'menu_type' => 1//Admin
            ],
            [
                'menu_id' => 'input',
                'menu_name' => 'Hằng Ngày',
                'menu_url' => '/admin/input-daily',
                'parent_menu_id' => null,
                'is_show' => 1,
                'menu_type' => 1//Admin
            ],
            [
                'menu_id' => 'sale_cart_small',
                'menu_name' => 'Xe Nhỏ',
                'menu_url' => '/admin/sale-cart-small',
                'parent_menu_id' => null,
                'is_show' => 1,
                'menu_type' => 1//Admin
            ],
            [
                'menu_id' => 'sale_report',
                'menu_name' => 'Doanh Số',
                'menu_url' => '/admin/sale-report',
                'parent_menu_id' => null,
                'is_show' => 1,
                'menu_type' => 1//Admin
            ],
            [
                'menu_id' => 'check_in',
                'menu_name' => 'Đặt Hàng',
                'menu_url' => '/admin/check-in-daily',
                'parent_menu_id' => null,
                'is_show' => 1,
                'menu_type' => 1//Admin
            ],
            [
                'menu_id' => 'time_keeping',
                'menu_name' => 'Chấm Công',
                'menu_url' => '/admin/time-keeping',
                'parent_menu_id' => null,
                'is_show' => 1,
                'menu_type' => 1//Admin
            ],
            [
                'menu_id' => 'payment_bill',
                'menu_name' => 'Phiếu Chi',
                'menu_url' => '/admin/payment-bill',
                'parent_menu_id' => null,
                'is_show' => 1,
                'menu_type' => 1//Admin
            ],
            [
                'menu_id' => 'finance',
                'menu_name' => 'Tài Chính',
                'menu_url' => '/admin/finance',
                'parent_menu_id' => null,
                'is_show' => 1,
                'menu_type' => 1//Admin
            ],
            [
                'menu_id' => 'setting',
                'menu_name' => 'Cài Đặt',
                'menu_url' => '',
                'parent_menu_id' => null,
                'is_show' => 1,
                'menu_type' => 1//Admin
            ],
            [
                'menu_id' => 'employee',
                'menu_name' => 'Nhân Viên',
                'menu_url' => '/admin/setting/employee',
                'parent_menu_id' => 'setting',
                'is_show' => 1,
                'menu_type' => 1//Admin
            ],
            [
                'menu_id' => 'setting_of_day',
                'menu_name' => 'Thiết Lặp Ngày Nghĩ',
                'menu_url' => '/admin/setting/setting-of-day',
                'parent_menu_id' => 'setting',
                'is_show' => 1,
                'menu_type' => 1//Admin
            ]
        ];
        foreach ($arraySuppliers as $supplier){
            DB::table(Menu::getTableName())->insert([
                'menu_id' => $supplier['menu_id'],
                'menu_name' => $supplier['menu_name'],
                'menu_url' => $supplier['menu_url'],
                'parent_menu_id' => $supplier['parent_menu_id'],
                'is_show' => $supplier['is_show'],
                'menu_type' => $supplier['menu_type'],
            ]);
        }
    }
}
