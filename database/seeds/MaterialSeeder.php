<?php

use App\Models\Material;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayMaterial = [
            [
                'name' => 'Bánh mì hamburger',
                'unit' => 'Cái',
                'price' => 2600,
                'material_type_id' => 1
            ],
            [
                'name' => 'Bánh mì sandwich 1cm',
                'unit' => 'Miếng',
                'price' => 1071,
                'material_type_id' => 1
            ],
            [
                'name' => 'Bánh mì túi (Pita)',
                'unit' => 'Miếng',
                'price' => 2300,
                'material_type_id' => 1
            ],
            [
                'name' => 'Bánh mì hotdog',
                'unit' => 'Cái',
                'price' => 2350,
                'material_type_id' => 1
            ],
            [
                'name' => 'Tương Mayonaise',
                'unit' => 'Kg',
                'price' => 60000,
                'material_type_id' => 1
            ],
            [
                'name' => 'Tương cà lớn',
                'unit' => 'Lít',
                'price' => 25000,
                'material_type_id' => 1
            ],
            [
                'name' => 'Tương ớt Cholimex 2.1kg',
                'unit' => 'Chai',
                'price' => 9500,
                'material_type_id' => 1
            ],
            [
                'name' => 'Dầu ăn',
                'unit' => 'Lít',
                'price' => 21000,
                'material_type_id' => 1
            ],
            [
                'name' => 'Muối I.ốt',
                'unit' => 'Chai',
                'price' => 6000,
                'material_type_id' => 1
            ],
            [
                'name' => 'Tương mù tạc',
                'unit' => 'Kg',
                'price' => 65000,
                'material_type_id' => 1
            ],
            [
                'name' => 'Gà miếng',
                'unit' => 'Miếng',
                'price' => 7350,
                'material_type_id' => 1
            ],
            [
                'name' => 'Thịt hamburger',
                'unit' => 'Miếng',
                'price' => 2850,
                'material_type_id' => 1
            ],
            [
                'name' => 'Trứng gà',
                'unit' => 'Trái',
                'price' => 1900,
                'material_type_id' => 1
            ],
            [
                'name' => 'Pate',
                'unit' => 'Kg',
                'price' => 92000,
                'material_type_id' => 1
            ],
            [
                'name' => 'Chà bông xốp',
                'unit' => 'Kg',
                'price' => 207000,
                'material_type_id' => 1
            ],
            [
                'name' => 'Xúc xích',
                'unit' => 'Cây',
                'price' => 3500,
                'material_type_id' => 1
            ],
            [
                'name' => 'Jam bong',
                'unit' => 'Kg',
                'price' => 140000,
                'material_type_id' => 1
            ],
            [
                'name' => 'Pepsi',
                'unit' => 'Chai',
                'price' => 14500,
                'material_type_id' => 1
            ],
            [
                'name' => 'Sà lách',
                'unit' => 'Kg',
                'price' => 30000,
                'material_type_id' => 1
            ],
            [
                'name' => 'Cà chua',
                'unit' => 'Kg',
                'price' => 17000,
                'material_type_id' => 1
            ],
            [
                'name' => 'Dưa leo',
                'unit' => 'Kg',
                'price' => 17000,
                'material_type_id' => 1
            ],
            [
                'name' => 'Đồ chua',
                'unit' => 'Kg',
                'price' => 17000,
                'material_type_id' => 1
            ],
            [
                'name' => 'Hành tây',
                'unit' => 'Kg',
                'price' => 17000,
                'material_type_id' => 1
            ],
            // Nuoc Uong
            [
                'name' => 'Bột Ca Cao',
                'unit' => 'Kg',
                'price' => 51000,
                'material_type_id' => 2
            ],
            [
                'name' => 'Đường trắng',
                'unit' => 'Kg',
                'price' => 14500,
                'material_type_id' => 2
            ],
            [
                'name' => 'Sữa bột',
                'unit' => 'Kg',
                'price' => 51000,
                'material_type_id' => 2
            ],
            [
                'name' => 'Sữa đậu nành',
                'unit' => 'Kg',
                'price' => 51000,
                'material_type_id' => 2
            ],
            [
                'name' => 'Trà đen',
                'unit' => 'Kg',
                'price' => 56000,
                'material_type_id' => 2
            ],
            [
                'name' => 'Nước đá',
                'unit' => 'Kg',
                'price' => 18000,
                'material_type_id' => 2
            ],
            //Bao Bi
            [
                'name' => 'Khẩu trang y tế',
                'unit' => 'Cái',
                'price' => 350,
                'material_type_id' => 3
            ],
            [
                'name' => 'Bao tay xốp',
                'unit' => 'Cái',
                'price' => 50000,
                'material_type_id' => 3
            ],
            [
                'name' => 'Túi đựng ly 1p30s',
                'unit' => 'Kg',
                'price' => 65000,
                'material_type_id' => 3
            ],
            [
                'name' => 'Ly Logo',
                'unit' => 'Kg',
                'price' => 500,
                'material_type_id' => 3
            ],
            [
                'name' => 'Giấy gói bánh mì',
                'unit' => 'Cái',
                'price' => 370,
                'material_type_id' => 3
            ],
            [
                'name' => 'Khăn giấy',
                'unit' => 'Xấp',
                'price' => 4500,
                'material_type_id' => 3
            ],
            [
                'name' => 'Nắp ly',
                'unit' => 'Cái',
                'price' => 120,
                'material_type_id' => 3
            ],
            [
                'name' => 'Màng ép ly',
                'unit' => 'Cuộn',
                'price' => 470000,
                'material_type_id' => 3
            ],
            [
                'name' => 'Ống hút',
                'unit' => 'Bao',
                'price' => 21000,
                'material_type_id' => 3
            ],
            [
                'name' => 'Băng keo',
                'unit' => 'Cuộn',
                'price' => 1300,
                'material_type_id' => 3
            ],
            [
                'name' => 'Bịt rác đen lớn',
                'unit' => 'Cái',
                'price' => 1300,
                'material_type_id' => 3
            ],
            [
                'name' => 'Hộp buger Gà',
                'unit' => 'Cái',
                'price' => 1000,
                'material_type_id' => 3
            ],
            [
                'name' => 'Hộp nhựa đựng Sandwich',
                'unit' => 'Cái',
                'price' => 580,
                'material_type_id' => 3
            ],
            [
                'name' => 'Giấy gói Pita',
                'unit' => 'Cái',
                'price' => 630,
                'material_type_id' => 3
            ],
            [
                'name' => 'Hộp giấy Pita gà',
                'unit' => 'Cái',
                'price' => 1000,
                'material_type_id' => 3
            ],
            [
                'name' => 'Túi Hot Dog (Mới)',
                'unit' => 'Cái',
                'price' => 650,
                'material_type_id' => 3
            ],
            [
                'name' => 'Chỉ số màng ép',
                'unit' => 'Cái',
                'price' => 470000,
                'material_type_id' => 3
            ],
            [
                'name' => 'Thẻ cào',
                'unit' => 'Thẻ',
                'price' => 700,
                'material_type_id' => 3
            ],
        ];
        foreach ($arrayMaterial as $material) {
            $unit = \App\Models\Unit::where('unit_name',$material['unit'])->first();
            $unitId = 0;
            if(isset($unit)) $unitId = $unit->id;
            DB::table(Material::getTableName())->insert([
                'material_name' => $material['name'],
                'material_type_id' => $material['material_type_id'],
                'price' => $material['price'],
                'unit_id' => $unitId
            ]);
        }
    }
}
