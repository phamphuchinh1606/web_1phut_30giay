<script src="{{\App\Helpers\AppHelper::assetPublic('js/admin/selected_branch_month.js')}}"></script>
<script>
    $(document).ready(function(){
        $('input[name=selected_branch]').on('change',function(){
            SelectedBranchMonth.updateSelectedBranch($(this).val(),callBackUpdate);
        });

        $('input[name=selected_month]').on('change',function(){
            SelectedBranchMonth.updateSelectedMonth($(this).val(),callBackUpdate);
        });
    });

    function callBackUpdate(data){
        window.location.reload();
    }
</script>

<aside class="aside-menu">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#timeline" role="tab">
                <i class="icon-location-pin"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#messages" role="tab">
                <i class="icon-calendar"></i>
            </a>
        </li>
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" data-toggle="tab" href="#settings" role="tab">--}}
{{--                <i class="icon-settings"></i>--}}
{{--            </a>--}}
{{--        </li>--}}
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="timeline" role="tabpanel">
            <div class="list-group list-group-accent">
                <div
                    class="list-group-item list-group-item-accent-secondary bg-light text-center font-weight-bold text-muted text-uppercase small">
                    <i class="icon-location-pin"></i> Chi Nhánh
                </div>
                @foreach($branches as $branch)
                    <div class="list-group-item list-group-item-divider @if(\App\Helpers\SessionHelper::getSelectedBranchId() == $branch->id) active @endif">
                        <div class="p-2">
                            <input class="form-check-input" @if(\App\Helpers\SessionHelper::getSelectedBranchId() == $branch->id) checked @endif id="selected_branch_{{$branch->id}}" type="radio" value="{{$branch->id}}" name="selected_branch" >
                            <label for="selected_branch_{{$branch->id}}">{{$branch->branch_name }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="tab-pane" id="messages" role="tabpanel">
            <div class="list-group list-group-accent">
                <div
                    class="list-group-item list-group-item-accent-secondary bg-light text-center font-weight-bold text-muted text-uppercase small">
                    <i class="icon-calendar"></i> Chọn Tháng
                </div>
            </div>

            @foreach(\App\Helpers\DateTimeHelper::getArrayMonthByYearCurrent() as $month)
                <div class="list-group-item list-group-item-divider @if(\App\Helpers\SessionHelper::getSelectedMonth()->format('Y/m') == $month->date_str) active @endif">
                    <div class="p-2">
                        <input class="form-check-input" @if(\App\Helpers\SessionHelper::getSelectedMonth()->format('Y/m') == $month->date_str) checked @endif id="selected_month_{{$month->month}}" type="radio" value="{{$month->date->format('Y-m-d')}}" name="selected_month" >
                        <label for="selected_month_{{$month->month}}">{{$month->month_str }} ({{$month->date_str }})</label>
                    </div>
                </div>
            @endforeach

        </div>
        <div class="tab-pane p-3" id="settings" role="tabpanel">
            <h6>Settings</h6>
            <div class="aside-options">
                <div class="clearfix mt-4">
                    <small>
                        <b>Option 1</b>
                    </small>
                    <label class="switch switch-label switch-pill switch-success switch-sm float-right">
                        <input class="switch-input" type="checkbox" checked="">
                        <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
                    </label>
                </div>
                <div>
                    <small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua.</small>
                </div>
            </div>
            <div class="aside-options">
                <div class="clearfix mt-3">
                    <small>
                        <b>Option 2</b>
                    </small>
                    <label class="switch switch-label switch-pill switch-success switch-sm float-right">
                        <input class="switch-input" type="checkbox">
                        <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
                    </label>
                </div>
                <div>
                    <small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua.</small>
                </div>
            </div>
            <div class="aside-options">
                <div class="clearfix mt-3">
                    <small>
                        <b>Option 3</b>
                    </small>
                    <label class="switch switch-label switch-pill switch-success switch-sm float-right">
                        <input class="switch-input" type="checkbox">
                        <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
                    </label>
                </div>
            </div>
            <div class="aside-options">
                <div class="clearfix mt-3">
                    <small>
                        <b>Option 4</b>
                    </small>
                    <label class="switch switch-label switch-pill switch-success switch-sm float-right">
                        <input class="switch-input" type="checkbox" checked="">
                        <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
                    </label>
                </div>
            </div>
            <hr>
            <h6>System Utilization</h6>
            <div class="text-uppercase mb-1 mt-4">
                <small>
                    <b>CPU Usage</b>
                </small>
            </div>
            <div class="progress progress-xs">
                <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="25"
                     aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <small class="text-muted">348 Processes. 1/4 Cores.</small>
            <div class="text-uppercase mb-1 mt-2">
                <small>
                    <b>Memory Usage</b>
                </small>
            </div>
            <div class="progress progress-xs">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 70%" aria-valuenow="70"
                     aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <small class="text-muted">11444GB/16384MB</small>
            <div class="text-uppercase mb-1 mt-2">
                <small>
                    <b>SSD 1 Usage</b>
                </small>
            </div>
            <div class="progress progress-xs">
                <div class="progress-bar bg-danger" role="progressbar" style="width: 95%" aria-valuenow="95"
                     aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <small class="text-muted">243GB/256GB</small>
            <div class="text-uppercase mb-1 mt-2">
                <small>
                    <b>SSD 2 Usage</b>
                </small>
            </div>
            <div class="progress progress-xs">
                <div class="progress-bar bg-success" role="progressbar" style="width: 10%" aria-valuenow="10"
                     aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <small class="text-muted">25GB/256GB</small>
        </div>
    </div>
</aside>
