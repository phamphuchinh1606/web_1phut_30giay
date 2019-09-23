<div class="col-md-12">
    <style>
        table.table td{
            vertical-align: middle;
        }
    </style>
    <table class="table table-responsive-sm table-bordered table-sm" style="display: table">
        <thead>
        <tr class="text-center">
            @foreach($branches as $branch)
                <th>{{$branch->branch_short_name}}</th>
            @endforeach
            <th>Tổng</th>
        </tr>
        </thead>
        <tbody>
        @foreach($materials as $material)
            <tr class="bg-secondary theme-color">
                <td colspan="3">
                    {{$material->material_name}}
                </td>
            </tr>
            <tr class="text-center">
                @foreach($material->prepare_materials as $prepareMaterial)
                    <td>
                        @if($material->id == \App\Models\Material::MATERIAL_EGG_ID)
                            <span class="color-red">{{$prepareMaterial->prepare_qty_total}}</span> Miếng
                            <br>
                            Ham : {{$prepareMaterial->prepare_qty_ham}} m<br>
                            Pita : {{$prepareMaterial->prepare_qty_pita}} m<br>
                            Sandwich : {{$prepareMaterial->prepare_qty_sandwich}} m<br>
                        @else
                            <span class="color-red">{{$prepareMaterial->qty_material}}</span>
                        @endif
                    </td>
                @endforeach
                <td>
                    @if($material->id == \App\Models\Material::MATERIAL_EGG_ID)
                        <span class="color-red">{{$material->prepare_qty_total}}</span> Miếng
                        <br>
                        Ham : {{$material->prepare_qty_ham}} m<br>
                        Pita : {{$material->prepare_qty_pita}} m<br>
                        Sandwich : {{$material->prepare_qty_sandwich}} m<br>
                    @else
                        <span class="color-red">{{$material->total_qty_material}}</span>
                        <br>{{$material->total_part_qty_material}} Bịch
                        @if($material->total_part_qty_material_remainder > 0)
                            <br> {{$material->total_part_qty_material_remainder}} @if($material->id == \App\Models\Material::MATERIAL_SAUSAGE_ID) Cây @else Miếng @endif
                        @endif
                    @endif

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
