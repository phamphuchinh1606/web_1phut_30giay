<?php

namespace App\Policies;

use App\User;
use App\Models\PaymentBill;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentBillPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can view any payment bills.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
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
    public function view(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can create payment bills.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        dd('vao');
        return true;

    }

    /**
     * Determine whether the user can update the payment bill.
     *
     * @param  \App\User  $user
     * @param  \App\PaymentBill  $paymentBill
     * @return mixed
     */
    public function update(User $user, PaymentBill $paymentBill)
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
    public function delete(User $user, PaymentBill $paymentBill)
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
    public function restore(User $user, PaymentBill $paymentBill)
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
    public function forceDelete(User $user, PaymentBill $paymentBill)
    {
        //
    }
}
