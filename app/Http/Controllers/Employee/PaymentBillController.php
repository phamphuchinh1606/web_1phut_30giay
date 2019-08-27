<?php

namespace App\Http\Controllers\Employee;

use App\Helpers\DateTimeHelper;
use App\Helpers\SessionHelper;
use App\Models\PaymentBill;
use App\Repositories\Eloquents\PaymentBillRepository;
use App\Repositories\Eloquents\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentBillController extends Controller
{
    private $paymentBillRepository;
    private $userRepository;

    public function __construct(PaymentBillRepository $paymentBillRepository, UserRepository $userRepository)
    {
        $this->paymentBillRepository = $paymentBillRepository;
        $this->userRepository = $userRepository;
    }

    public function index($id = null,Request $request){

        $currentDate = SessionHelper::getSelectedMonth();
        $branchId = SessionHelper::getSelectedBranchId();
        $paymentBills = $this->paymentBillRepository->getList($branchId,$currentDate);
        $users = $this->userRepository->selectAll();
        if(isset($id)){
            $paymentBill = $this->paymentBillRepository->find($id);
        }else{
            $paymentBill = new PaymentBill();
            $paymentBill->qty = 1;
            $paymentBill->price = 0;
            $paymentBill->amount = 0;
        }
        return $this->viewEmployee('paymentBill.payment_bill',[
            'currentDate' => $currentDate,
            'branchId' => $branchId,
            'paymentBills' => $paymentBills,
            'users' => $users,
            'paymentBill' => $paymentBill
        ]);
    }

    public function create(Request $request){
        $input = $request->all();
        $this->paymentBillRepository->create($input);
        return redirect()->route('admin.payment_bill')->with('message','Đã thêm phiếu chi thành công');
    }

    public function update($id, Request $request){
        $inputs = $request->all();
        $inputs = array_merge($inputs,['id' => $id]);
        $this->paymentBillRepository->update($inputs);
        return redirect()->route('admin.payment_bill')->with('message','Cập Nhật Thành Công');
    }

    public function delete($id){
        $this->paymentBillRepository->deleteLogic(array('id' => $id));
        return redirect()->route('admin.payment_bill')->with('message','Xóa Thành Công');
    }
}
