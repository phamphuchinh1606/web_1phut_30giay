<?php

namespace App\Http\Controllers\Admin;

use App\Common\AppCommon;
use App\Common\Constant;
use Illuminate\Http\Request;
use App\Common\DateUtils;

class OrderController extends Controller
{
    private function getSearchInfo(Request $request){
        $searchForm = $request->only([
            'order_code', 'full_name', 'phone_number', 'email' , 'order_date' , 'order_status', 'page'
        ]);
        if(count($searchForm) == 0){
            $firstDayOfPreviousMonth = DateUtils::startOfMonth('m/d/Y');
            $lastDayOfPreviousMonth = DateUtils::endOfMonth('m/d/Y');
            $searchForm = array(
                'order_code' => null,
                'full_name' => null,
                'phone_number' => null,
                'email' => null,
                'order_date'  => $firstDayOfPreviousMonth . '-' . $lastDayOfPreviousMonth,
                'order_status' => null
            );
        }
        if(isset($searchForm['order_date'])){
            $dateArray = explode('-',$searchForm['order_date']);
            if(count($dateArray) > 0){
                $searchForm['order_date_start'] = AppCommon::dateFormat($dateArray[0],'Y/m/d') ;
                $searchForm['order_date_end'] =  AppCommon::dateFormat($dateArray[1],'Y/m/d');
            }
        }
        return $searchForm;
    }

    public function index(Request $request){
        $searchForm = $this->getSearchInfo($request);
        $orders = $this->orderService->getAll($searchForm);
        foreach ($searchForm as $key => $value){
            if(null == $searchForm[$key]){
                $searchForm[$key] = '';
            }
        }
        return $this->viewAdmin('order.index',[
            'orders' => $orders,
            'searchForm' => $searchForm
        ]);
    }

    public function detail($id){
        $order = $this->orderService->getDetail($id);
        $isShowConfirm = false;
        $isShowShipping = false;
        $isShowFinish = false;
        $isShowCancel = false;
        switch ($order->status_order){
            case Constant::$ORDER_STATUS_NEW_CODE:
                $isShowConfirm = true;
                $isShowShipping = true;
                $isShowFinish = true;
                $isShowCancel = true;
                break;
            case Constant::$ORDER_STATUS_CONFIRM_CODE:
                $isShowShipping = true;
                $isShowFinish = true;
                $isShowCancel = true;
                break;
            case Constant::$ORDER_STATUS_SHIPPING_CODE:
                $isShowFinish = true;
                $isShowCancel = true;
                break;
            case Constant::$ORDER_STATUS_FINISH_CODE:
                $isShowCancel = true;
                break;
            case Constant::$ORDER_STATUS_CANCEL_CODE:
                break;
        }
        return $this->viewAdmin('order.detail',[
            'order' => $order,
            'isShowConfirm' => $isShowConfirm,
            'isShowShipping' => $isShowShipping,
            'isShowFinish' => $isShowFinish,
            'isShowCancel' => $isShowCancel
        ]);
    }

    public function statusConfirm($id){
        $this->orderService->updateStatusOrder($id, Constant::$ORDER_STATUS_CONFIRM_CODE);
        return redirect()->route('admin.order.index')->with('message','Bạn đã xác nhận đơn hàng thành công');
    }

    public function statusShipping($id){
        $this->orderService->updateStatusOrder($id, Constant::$ORDER_STATUS_SHIPPING_CODE);
        return redirect()->route('admin.order.index')->with('message','Bạn đã chuyển trạng thái vận chuyển đơn hàng thành công');
    }

    public function statusFinish($id){
        $this->orderService->updateStatusOrder($id, Constant::$ORDER_STATUS_FINISH_CODE);
        return redirect()->route('admin.order.index')->with('message','Bạn đã hoàn thành đơn hàng thành công');
    }

    public function statusCancel($id){
        $this->orderService->updateStatusOrder($id, Constant::$ORDER_STATUS_CANCEL_CODE);
        return redirect()->route('admin.order.index')->with('message','Bạn đã hủy đơn hàng thành công');
    }
}
