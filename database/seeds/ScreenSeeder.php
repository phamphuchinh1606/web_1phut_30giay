<?php

use App\Models\Screen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Route;

class ScreenSeeder extends Seeder
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
                'screen_id' => 'home',
                'screen_name' => 'Trang Chủ',
                'screen_url' => '/admin',
                'parent_screen_id' => null,
                'screen_type' => 1//Admin
            ],
            [
                'screen_id' => 'input',
                'screen_name' => 'Hằng Ngày',
                'screen_url' => '/admin/input-daily',
                'parent_screen_id' => null,
                'screen_type' => 1//Admin
            ],
            [
                'screen_id' => 'sale_cart_small',
                'screen_name' => 'Xe Nhỏ',
                'screen_url' => '/admin/sale-cart-small',
                'parent_screen_id' => null,
                'screen_type' => 1//Admin
            ],
            [
                'screen_id' => 'sale_report',
                'screen_name' => 'Doanh Số',
                'screen_url' => '/admin/sale-report',
                'parent_screen_id' => null,
                'screen_type' => 1//Admin
            ],
            [
                'screen_id' => 'check_in',
                'screen_name' => 'Đặt Hàng',
                'screen_url' => '/admin/check-in-daily',
                'parent_screen_id' => null,
                'screen_type' => 1//Admin
            ],
            [
                'screen_id' => 'time_keeping',
                'screen_name' => 'Chấm Công',
                'screen_url' => '/admin/time-keeping',
                'parent_screen_id' => null,
                'screen_type' => 1//Admin
            ],
            [
                'screen_id' => 'payment_bill',
                'screen_name' => 'Phiếu Chi',
                'screen_url' => '/admin/payment-bill',
                'parent_screen_id' => null,
                'screen_type' => 1//Admin
            ],
            [
                'screen_id' => 'finance',
                'screen_name' => 'Tài Chính',
                'screen_url' => '/admin/finance',
                'parent_screen_id' => null,
                'screen_type' => 1//Admin
            ],
            [
                'screen_id' => 'setting',
                'screen_name' => 'Cài Đặt',
                'screen_url' => '',
                'parent_screen_id' => null,
                'screen_type' => 1//Admin
            ],
            [
                'screen_id' => 'employee',
                'screen_name' => 'Nhân Viên',
                'screen_url' => '/admin/setting/employee',
                'parent_screen_id' => 'setting',
                'screen_type' => 1//Admin
            ],
            [
                'screen_id' => 'setting_of_day',
                'screen_name' => 'Thiết Lặp Ngày Nghĩ',
                'screen_url' => '/admin/setting/setting-of-day',
                'parent_screen_id' => 'setting',
                'screen_type' => 1//Admin
            ]
        ];
        foreach ($arraySuppliers as $supplier){
            DB::table(Screen::getTableName())->insert([
                'screen_id' => $supplier['screen_id'],
                'screen_name' => $supplier['screen_name'],
                'screen_url' => $supplier['screen_url'],
                'parent_screen_id' => $supplier['parent_screen_id'],
                'is_show' => $supplier['is_show'],
                'screen_type' => $supplier['screen_type'],
            ]);
        }
    }
}
