<?php

namespace App\Models;

class PaymentBill extends BaseModel
{
    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }
}
