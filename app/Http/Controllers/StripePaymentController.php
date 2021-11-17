<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
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

//        $validator = Validator::make($request->all(), [
//            'card_no' => 'required',
//            'cc_expiry_month' => 'required',
//            'cc_expiry_year' => 'required',
//            'cvc' => 'required',
//        ]);
        return 1;
        if ($validator->fails()) {
            return redirect(route('stripe', $order->id))->withErrors($validator);
        } else {
            $stripe = \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            try {
                $charge = \Stripe\Charge::create([
                    'source' => $request->stripeToken,
                    'currency' => 'USD',
                    'amount' => $order->total*100,
                    'description' => 'wallet',
                ]);

                if($charge['status'] == 'succeeded') {
                    $order = Order::find($order->id);
                    $order->update(['order_status_id' => 3, 'pay_by' => 'stripe']);
                    return redirect()->route('orders.edit', $order->id)->with('message', 'Thank you! We have received you order. We will contact you shortly with free quotation.');
                } else {
                    Session::put('error','Payment failed!!');
                    return redirect()->route('stripe', $order->id)->with('message', 'A error has occurred, and you have not been charged. Please try again.');
                }
            } catch (Exception $e) {
                Session::put('error', $e->getMessage());
                return redirect()->route('stripe', $order->id)->with('message', 'A error has occurred, and you have not been charged. Please try again.');
            } catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
                Session::put('error', $e->getMessage());
                return redirect()->route('stripe', $order->id)->with('message', 'A error has occurred, and you have not been charged. Please try again.');
            } catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
                Session::put('error', $e->getMessage());
                return redirect()->route('stripe', $order->id)->with('message', 'A error has occurred, and you have not been charged. Please try again.');
            }
            return redirect()->route('stripe', $order->id)->with('message', 'A error has occurred, and you have not been charged. Please try again.');
        }
    }
}
