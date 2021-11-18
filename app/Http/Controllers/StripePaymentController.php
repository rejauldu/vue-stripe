<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\BillingNotification;
use Illuminate\Http\Request;
use Auth;
use Notification;
use Illuminate\Support\Facades\Hash;
use Session;
use Validator;
use App\Models\Order;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe($id)
    {
        $order = Order::find($id);
        return view('backend.stripe.stripe', compact('order'));
    }
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function purchase(Request $request)
    {
        $input = $request->except('_token');
        $order = Order::find($request->order_id);

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'amount' => 'required',
            'payment_method_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid input'], 500);
        } else {
            $user = User::firstOrCreate(
                [
                    'email' => $request->email
                ],
                [
                    'password' => Hash::make('password')
                ]
            );
            try {
                $payment = $user->charge(
                    ceil($request->amount * 100),
                    $request->payment_method_id
                );
                Notification::send($user, new BillingNotification($request));
                $payment = $payment->asStripePaymentIntent();
            } catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage()], 500);
            }
        }
        return response()->json(['message' => 'Payment Completed'], 200);
    }
}
