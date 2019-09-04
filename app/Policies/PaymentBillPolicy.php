<?php

namespace App\Policies;

use App\User;
use App\Models\PaymentBill;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PaymentBillPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can view any payment bills.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(Authenticatable $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the payment bill.
     *
     * @param  \App\User  $user
     * @param  \App\PaymentBill  $paymentBill
     * @return mixed
     */
    public function view(Authenticatable $user)
    {
        return true;
    }

    /**
     * Determine whether the user can create payment bills.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(Authenticatable $user)
    {
        return true;

    }

    /**
     * Determine whether the user can update the payment bill.
     *
     * @param  \App\User  $user
     * @param  \App\PaymentBill  $paymentBill
     * @return mixed
     */
    public function update(Authenticatable $user, PaymentBill $paymentBill)
    {
        //
    }

    /**
     * Determine whether the user can delete the payment bill.
     *
     * @param  \App\User  $user
     * @param  \App\PaymentBill  $paymentBill
     * @return mixed
     */
    public function delete(Authenticatable $user, PaymentBill $paymentBill)
    {
        //
    }

    /**
     * Determine whether the user can restore the payment bill.
     *
     * @param  \App\User  $user
     * @param  \App\PaymentBill  $paymentBill
     * @return mixed
     */
    public function restore(Authenticatable $user, PaymentBill $paymentBill)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the payment bill.
     *
     * @param  \App\User  $user
     * @param  \App\PaymentBill  $paymentBill
     * @return mixed
     */
    public function forceDelete(Authenticatable $user, PaymentBill $paymentBill)
    {
        //
    }
}
