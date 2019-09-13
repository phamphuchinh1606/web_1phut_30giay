<?php

use App\Models\Material;
use App\Repositories\Eloquents\MaterialRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    protected $materialRepository;

    public function __construct(MaterialRepository $materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }

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
                'short_name' => 'Ham',
                'unit' => 'Cái',
                'price' => 2600,
                'material_type_id' => 1
            ],
            [
                'name' => 'Bánh mì sandwich 1cm',
                'short_name' => 'SW',
                'unit' => 'Miếng',
                'price' => 1071,
                'material_type_id' => 1
            ],
            [
                'name' => 'Bánh mì túi (Pita)',
                'short_name' => 'Pita',
                'unit' => 'Miếng',
                'price' => 2300,
                'material_type_id' => 1
            ],
            [
                'name' => 'Bánh mì hotdog',
                'short_name' => 'Hotdog',
                'unit' => 'Cái',
                'price' => 2350,
                'material_type_id' => 1
            ],
            [
                'name' => 'Tương Mayonaise',
                'short_name' => 'Mayonaise',
                'unit' => 'Kg',
                'price' => 60000,
                'material_type_id' => 1
            ],
            [
                'name' => 'Tương cà lớn',
                'short_name' => 'T.Cà',
                'unit' => 'Lít',
                'price' => 25000,
                'material_type_id' => 1
            ],
            [
                'name' => 'Tương ớt Cholimex 2.1kg',
                'short_name' => 'T.Ớt',
                'unit' => 'Chai',
                'price' => 9500,
                'material_type_id' => 1
            ],
            [
                'name' => 'Dầu ăn',
                'short_name' => 'Dầu',
                'unit' => 'Lít',
                'price' => 21000,
                'material_type_id' => 1
            ],
            [
                'name' => 'Muối I.ốt',
                'short_name' => 'Muối',
                'unit' => 'Chai',
                'price' => 6000,
                'material_type_id' => 1
            ],
            [
                'name' => 'Tương mù tạc',
                'short_name' => 'Mù tạc',
                'unit' => 'Kg',
                'price' => 65000,
                'material_type_id' => 1
            ],
            [
                'name' => 'Gà miếng',
                'short_name' => 'Gà',
                'unit' => 'Miếng',
                'price' => 7350,
                'material_type_id' => 1
            ],
            [
                'name' => 'Thịt hamburger',
                'short_name' => 'Thịt',
                'unit' => 'Miếng',
                'price' => 2850,
                'material_type_id' => 1
            ],
            [
                'name' => 'Trứng gà',
                'short_name' => 'Trứng',
                'unit' => 'Trái',
                'price' => 1900,
                'material_type_id' => 1
            ],
            [
                'name' => 'Pate',
                'short_name' => 'Pate',
                'unit' => 'Kg',
                'price' => 92000,
                'material_type_id' => 1
            ],
            [
                'name' => 'Chà bông xốp',
                'short_name' => 'Chà bông',
                'unit' => 'Kg',
                'price' => 207000,
                'material_type_id' => 1
            ],
            [
                'name' => 'Xúc xích',
                'short_name' => 'X.xích',
                'unit' => 'Cây',
                'price' => 3500,
                'material_type_id' => 1
            ],
            [
                'name' => 'Jam bong',
                'short_name' => 'Jam bông',
                'unit' => 'Kg',
                'price' => 140000,
                'material_type_id' => 1
            ],
            [
                'name' => 'Pepsi',
                'short_name' => 'Pepsi',
                'unit' => 'Chai',
                'price' => 14000,
                'material_type_id' => 1
            ],
            [
                'name' => 'Sà lách',
                'short_name' => 'Salack',
                'unit' => 'Kg',
                'price' => 30000,
                'material_type_id' => 1
            ],
            [
                'name' => 'Cà chua',
                'short_name' => 'Cà chua',
                'unit' => 'Kg',
                'price' => 20000,
                'material_type_id' => 1
            ],
            [
                'name' => 'Dưa leo',
                'short_name' => 'Dưa leo',
                'unit' => 'Kg',
                'price' => 16000,
                'material_type_id' => 1
            ],
            [
                'name' => 'Đồ chua',
                'short_name' => 'Dồ chua',
                'unit' => 'Kg',
                'price' => 17000,
                'material_type_id' => 1,
                'is_show_input' => 0
            ],
            [
                'name' => 'Hành tây',
                'short_name' => 'Hành',
                'unit' => 'Kg',
                'price' => 17000,
                'material_type_id' => 1,
                'is_show_input' => 0
            ],
            // Nuoc Uong
            [
                'name' => 'Bột Ca Cao',
                'short_name' => 'Ca Cao',
                'unit' => 'Kg',
                'price' => 51000,
                'material_type_id' => 2
            ],
            [
                'name' => 'Đường trắng',
                'short_name' => 'Đường',
                'unit' => 'Kg',
                'price' => 14500,
                'material_type_id' => 2
            ],
            [
                'name' => 'Sữa bột',
                'short_name' => 'Sữa bột',
                'unit' => 'Kg',
                'price' => 51000,
                'material_type_id' => 2
            ],
            [
                'name' => 'Sữa đậu nành',
                'short_name' => 'Đậu nành',
                'unit' => 'Kg',
                'price' => 51000,
                'material_type_id' => 2
            ],
            [
                'name' => 'Trà đen',
                'short_name' => 'Trà',
                'unit' => 'Kg',
                'price' => 56000,
                'material_type_id' => 2
            ],
            [
                'name' => 'Nước đá',
                'short_name' => 'Đá',
                'unit' => 'Kg',
                'price' => 20000,
                'material_type_id' => 2,
                'supplier_id' => 2
            ],
            //Bao Bi
            [
                'name' => 'Khẩu trang y tế',
                'short_name' => 'Khẩu trang',
                'unit' => 'Cái',
                'price' => 350,
                'material_type_id' => 3
            ],
            [
                'name' => 'Bao tay xốp',
                'short_name' => 'Bao tay',
                'unit' => 'Cái',
                'price' => 50000,
                'material_type_id' => 3
            ],
            [
                'name' => 'Túi đựng ly 1p30s',
                'short_name' => 'Túi',
                'unit' => 'Kg',
                'price' => 65000,
                'material_type_id' => 3
            ],
            [
                'name' => 'Ly Logo',
                'short_name' => 'Ly',
                'unit' => 'Kg',
                'price' => 500,
                'material_type_id' => 3
            ],
            [
                'name' => 'Giấy gói bánh mì',
                'short_name' => 'Giấy gói',
                'unit' => 'Cái',
                'price' => 370,
                'material_type_id' => 3
            ],
            [
                'name' => 'Khăn giấy',
                'short_name' => 'Khăn giấy',
                'unit' => 'Xấp',
                'price' => 4500,
                'material_type_id' => 3
            ],
            [
                'name' => 'Nắp ly',
                'short_name' => 'Nắp ly',
                'unit' => 'Cái',
                'price' => 120,
                'material_type_id' => 3
            ],
            [
                'name' => 'Màng ép ly',
                'short_name' => 'Màng ép',
                'unit' => 'Cuộn',
                'price' => 470000,
                'material_type_id' => 3
            ],
            [
                'name' => 'Ống hút',
                'short_name' => 'Ống hút',
                'unit' => 'Bao',
                'price' => 21000,
                'material_type_id' => 3
            ],
            [
                'name' => 'Băng keo',
                'short_name' => 'Băng keo',
                'unit' => 'Cuộn',
                'price' => 1300,
                'material_type_id' => 3
            ],
            [
                'name' => 'Bịt rác đen lớn',
                'short_name' => 'Bịt rác',
                'unit' => 'Cái',
                'price' => 1300,
                'material_type_id' => 3
            ],
            [
                'name' => 'Hộp buger Gà',
                'short_name' => 'Hộp gà',
                'unit' => 'Cái',
                'price' => 1000,
                'material_type_id' => 3
            ],
            [
                'name' => 'Hộp nhựa đựng Sandwich',
                'short_name' => 'Hộp SW',
                'unit' => 'Cái',
                'price' => 580,
                'material_type_id' => 3
            ],
            [
                'name' => 'Giấy gói Pita',
                'short_name' => 'Giấy pita',
                'unit' => 'Cái',
                'price' => 630,
                'material_type_id' => 3
            ],
            [
                'name' => 'Hộp giấy Pita gà',
                'short_name' => 'Giấy pita gà',
                'unit' => 'Cái',
                'price' => 1000,
                'material_type_id' => 3,
                'is_show_input' => 0
            ],
            [
                'name' => 'Túi Hot Dog (Mới)',
                'short_name' => 'Túi Hotdog',
                'unit' => 'Cái',
                'price' => 650,
                'material_type_id' => 3
            ],
            [
                'name' => 'Chỉ số màng ép',
                'short_name' => 'Chỉ số',
                'unit' => 'Cái',
                'price' => 470000,
                'material_type_id' => 3
            ],
            [
                'name' => 'Thẻ cào',
                'short_name' => 'Thẻ cào',
                'unit' => 'Thẻ',
                'price' => 700,
                'material_type_id' => 3
            ],
        ];
        foreach ($arrayMaterial as $material) {
            //Update material
//            $materialDB = $this->materialRepository->findByKey(['material_name' => $material['name']]);
//            if(isset($materialDB)){
//                $materialDB['material_short_name'] = $material['short_name'];
//                $materialDB->material_short_name = $material['short_name'];
//                DB::listen(function($query){
//                    dd($query);
//                });
//                $this->materialRepository->updateModel($materialDB);
//            }
            $unit = \App\Models\Unit::where('unit_name',$material['unit'])->first();
            $unitId = 0;
            if(isset($unit)) $unitId = $unit->id;
            DB::table(Material::getTableName())->insert([
                'material_name' => $material['name'],
                'material_short_name' => $material['short_name'],
                'material_type_id' => $material['material_type_id'],
                'price' => $material['price'],
                'unit_id' => $unitId,
                'supplier_id' => isset($material['supplier_id']) ? $material['supplier_id'] : 1,
                'is_show_input' => isset($material['is_show_input']) ? $material['is_show_input'] : 1,
            ]);
        }
    }
}
