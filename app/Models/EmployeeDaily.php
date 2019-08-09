<?php

namespace App\Models;

class EmployeeDaily extends BaseModel
{
    public function getAmountFirstAttribute(){
        return $this->first_hours * $this->price_first_hour;
    }

    public function getAmountLastAttribute(){
        return $this->last_hours * $this->price_last_hour;
    }

    public function getAmountAttribute(){
        return $this->amount_first + $this->amount_last;
    }
}
