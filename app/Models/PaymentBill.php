<?php

namespace App\Models;

class PaymentBill extends BaseModel
{
    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
}
