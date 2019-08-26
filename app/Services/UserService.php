<?php
namespace App\Services;

use App\Common\Constant;
use App\Helpers\AppHelper;
use App\Helpers\ArrayHelper;
use App\Helpers\DateTimeHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService {

    public function createUser($values){
        try{
            DB::beginTransaction();
            if(isset($values['password'])) {
                $values['password'] = Hash::make($values['password']);
            }
            $user = $this->userRepository->create($values);
            if(isset($values['selected_branch'])){
                $branchIds = $values['selected_branch'];
                if(isset($branchIds)){
                    foreach ($branchIds as $branchId){
                        $this->userBranchRepository->create(array('user_id' => $user->id, 'branch_id' => $branchId));
                    }
                }
            }
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            dd($ex);
        }
    }

    public function updateUser($values){
        try{
            DB::beginTransaction();
            $user = $this->userRepository->update($values);
            if(isset($user)){
                $user->deleteRelation();
                if(isset($values['selected_branch'])){
                    $branchIds = $values['selected_branch'];
                    if(isset($branchIds)){
                        foreach ($branchIds as $branchId){
                            $this->userBranchRepository->create(array('user_id' => $user->id, 'branch_id' => $branchId));
                        }
                    }
                }
            }

            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            dd($ex);
        }
    }

}
