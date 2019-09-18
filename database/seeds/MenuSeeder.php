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
                'menu_route' => 'admin.home',
                'menu_icon_class' => 'icon-home',
                'parent_menu_id' => null,
                'is_show' => 1,
                'menu_type' => 1,//Admin
                'sort_num' => 1
            ],
            [
                'menu_id' => 'input',
                'menu_name' => 'Hằng Ngày',
                'menu_url' => '/admin/input-daily',
                'menu_route' => 'admin.input_daily',
                'menu_icon_class' => 'icon-calendar',
                'parent_menu_id' => null,
                'is_show' => 1,
                'menu_type' => 1,//Admin
                'sort_num' => 2
            ],
            [
                'menu_id' => 'sale_cart_small',
                'menu_name' => 'Xe Nhỏ',
                'menu_url' => '/admin/sale-cart-small',
                'menu_route' => 'admin.sale_card_small',
                'menu_icon_class' => 'icon-trophy',
                'parent_menu_id' => null,
                'is_show' => 1,
                'menu_type' => 1,//Admin
                'sort_num' => 3
            ],
            [
                'menu_id' => 'prepare_material',
                'menu_name' => 'Chuẩn Bị Nguyên Liệu',
                'menu_url' => '/admin/prepare-material',
                'menu_route' => 'admin.prepare_material',
                'menu_icon_class' => 'icon-globe-alt',
                'parent_menu_id' => null,
                'is_show' => 1,
                'menu_type' => 1,//Admin
                'sort_num' => 3
            ],
            [
                'menu_id' => 'sale_report',
                'menu_name' => 'Doanh Số',
                'menu_url' => '/admin/sale-report',
                'menu_route' => 'admin.sale_report',
                'menu_icon_class' => 'icon-support',
                'parent_menu_id' => null,
                'is_show' => 1,
                'menu_type' => 1,//Admin
                'sort_num' => 4
            ],
            [
                'menu_id' => 'check_in',
                'menu_name' => 'Đặt Hàng',
                'menu_url' => '/admin/check-in-daily',
                'menu_route' => 'admin.check_in.daily',
                'menu_icon_class' => 'icon-book-open',
                'parent_menu_id' => null,
                'is_show' => 1,
                'menu_type' => 1,//Admin
                'sort_num' => 5
            ],
            [
                'menu_id' => 'check_in_charge',
                'menu_name' => 'Đặt Hàng Thêm',
                'menu_url' => '/admin/check-in-charge',
                'menu_route' => 'admin.check_in.check_in_charge',
                'menu_icon_class' => 'icon-handbag',
                'parent_menu_id' => null,
                'is_show' => 1,
                'menu_type' => 1,//Admin
                'sort_num' => 6
            ],
            [
                'menu_id' => 'time_keeping',
                'menu_name' => 'Chấm Công',
                'menu_url' => '/admin/time-keeping',
                'menu_route' => 'admin.time_keeping',
                'menu_icon_class' => 'icon-layers',
                'parent_menu_id' => null,
                'is_show' => 1,
                'menu_type' => 1,//Admin
                'sort_num' => 7
            ],
            [
                'menu_id' => 'payment_bill',
                'menu_name' => 'Phiếu Chi',
                'menu_url' => '/admin/payment-bill',
                'menu_route' => 'admin.payment_bill',
                'menu_icon_class' => 'icon-diamond',
                'parent_menu_id' => null,
                'is_show' => 1,
                'menu_type' => 1,//Admin
                'sort_num' => 8
            ],
            [
                'menu_id' => 'finance',
                'menu_name' => 'Tài Chính',
                'menu_url' => '/admin/finance',
                'menu_route' => 'admin.finance',
                'menu_icon_class' => 'icon-fire',
                'parent_menu_id' => null,
                'is_show' => 1,
                'menu_type' => 1,//Admin
                'sort_num' => 9
            ],
            [
                'menu_id' => 'setting',
                'menu_name' => 'Cài Đặt',
                'menu_url' => '',
                'menu_route' => '',
                'menu_icon_class' => 'icon-settings',
                'parent_menu_id' => null,
                'is_show' => 1,
                'menu_type' => 1,//Admin
                'sort_num' => 10
            ],
            [
                'menu_id' => 'employee',
                'menu_name' => 'Nhân Viên',
                'menu_url' => '/admin/setting/employee',
                'menu_route' => 'admin.employee',
                'menu_icon_class' => 'icon-people',
                'parent_menu_id' => 'setting',
                'is_show' => 1,
                'menu_type' => 1,//Admin
                'sort_num' => 10,
                'child_sort_num' => 1
            ],
            [
                'menu_id' => 'small_car',
                'menu_name' => 'Danh Sách Xe Nhỏ',
                'menu_url' => '/admin/setting/small-car',
                'menu_route' => 'admin.setting.small_car',
                'menu_icon_class' => 'icon-drop',
                'parent_menu_id' => 'setting',
                'is_show' => 1,
                'menu_type' => 1,//Admin
                'sort_num' => 10,
                'child_sort_num' => 2
            ],
            [
                'menu_id' => 'user',
                'menu_name' => 'NV Quản Lý',
                'menu_url' => 'admin/setting/user',
                'menu_route' => 'admin.user',
                'menu_icon_class' => 'icon-user-following',
                'parent_menu_id' => 'setting',
                'is_show' => 1,
                'menu_type' => 1,//Admin
                'sort_num' => 10,
                'child_sort_num' => 2
            ],
            [
                'menu_id' => 'setting_of_day',
                'menu_name' => 'Thiết Lặp Ngày Nghĩ',
                'menu_url' => '/admin/setting/setting-of-day',
                'menu_route' => 'admin.setting.setting_of_day',
                'menu_icon_class' => 'icon-equalizer',
                'parent_menu_id' => 'setting',
                'is_show' => 1,
                'menu_type' => 1,//Admin
                'sort_num' => 10,
                'child_sort_num' => 3
            ],
            [
                'menu_id' => 'setting_app',
                'menu_name' => 'Thông Tin Hệ Thống',
                'menu_url' => '/admin/setting/setting-app',
                'menu_route' => 'admin.setting.setting_app',
                'menu_icon_class' => 'icon-graduation',
                'parent_menu_id' => 'setting',
                'is_show' => 1,
                'menu_type' => 1,//Admin
                'sort_num' => 10,
                'child_sort_num' => 4
            ],
            [
                'menu_id' => 'setting_material',
                'menu_name' => 'Nguyên Liệu',
                'menu_url' => '/admin/setting/material',
                'menu_route' => 'admin.material',
                'menu_icon_class' => 'icon-energy',
                'parent_menu_id' => 'setting',
                'is_show' => 1,
                'menu_type' => 1,//Admin
                'sort_num' => 10,
                'child_sort_num' => 5
            ],
            [
                'menu_id' => 'setting_role',
                'menu_name' => 'Thiết Lặp Quyền',
                'menu_url' => '/admin/setting/role',
                'menu_route' => 'admin.setting.role',
                'menu_icon_class' => 'icon-directions',
                'parent_menu_id' => 'setting',
                'is_show' => 1,
                'menu_type' => 1,//Admin
                'sort_num' => 10,
                'child_sort_num' => 6
            ],
            //Employee Screen
            [
                'menu_id' => 'input_employee',
                'menu_name' => 'Hằng Ngày',
                'menu_url' => '/input-daily',
                'menu_route' => 'input_daily',
                'menu_icon_class' => 'icon-calendar',
                'parent_menu_id' => null,
                'is_show' => 1,
                'menu_type' => 2,//Employee
                'sort_num' => 1
            ],
            [
                'menu_id' => 'sale_cart_small_employee',
                'menu_name' => 'Xe Nhỏ',
                'menu_url' => '/sale-cart-small',
                'menu_route' => 'sale_card_small',
                'menu_icon_class' => 'icon-trophy',
                'parent_menu_id' => null,
                'is_show' => 1,
                'menu_type' => 2,//Admin
                'sort_num' => 2
            ],
            [
                'menu_id' => 'time_keeping_employee',
                'menu_name' => 'Chấm Công',
                'menu_url' => '/time-keeping',
                'menu_route' => 'time_keeping',
                'menu_icon_class' => 'icon-layers',
                'parent_menu_id' => null,
                'is_show' => 1,
                'menu_type' => 2,//Admin
                'sort_num' => 3
            ],
            [
                'menu_id' => 'payment_bill_employee',
                'menu_name' => 'Phiếu Chi',
                'menu_url' => '/payment-bill',
                'menu_route' => 'payment_bill',
                'menu_icon_class' => 'icon-diamond',
                'parent_menu_id' => null,
                'is_show' => 1,
                'menu_type' => 2,//Admin
                'sort_num' => 4
            ],
        ];
        foreach ($arraySuppliers as $supplier){
            DB::table(Menu::getTableName())->insert([
                'menu_id' => $supplier['menu_id'],
                'menu_name' => $supplier['menu_name'],
                'menu_url' => $supplier['menu_url'],
                'parent_menu_id' => $supplier['parent_menu_id'],
                'is_show' => $supplier['is_show'],
                'menu_type' => $supplier['menu_type'],
                'menu_route' => $supplier['menu_route'],
                'menu_icon_class' => $supplier['menu_icon_class'],
                'sort_num' => $supplier['sort_num'],
                'child_sort_num' => isset($supplier['child_sort_num']) ? $supplier['child_sort_num'] : null,
            ]);
        }
    }
}
