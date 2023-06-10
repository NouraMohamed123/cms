<?php

namespace App\Http\Controllers\Front;

use App\Models\Order;
use App\Models\OrderAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Nafezly\Payments\Classes\PaymobPayment;
use Nafezly\Payments\Classes\PayPalPayment;
use Stripe;
class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontend.checkout');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // $request->validate([
            //     'name' => 'required',
            //     'email' => 'required|email',
            //     'address' => 'required',
            //     'city' => 'required',
            //     'state' => 'required',
            //     'zip' => 'required',
            //     'country' => 'required',
            //     'payment_option' => 'required',
            // ]);

            // Create a new order
            $order = new Order();
            $order->payment_method = $request->payment_option;
            $order->product_id = $request->product_id;
            $order->save();

            $address = new OrderAddress();
            $address->order_id = $order->id;
            $address->name = $request->input('name');
            $address->email = $request->input('email');
            $address->address = $request->input('address');
            $address->city = $request->input('city');
            $address->state = $request->input('state');
            $address->zip = $request->input('zip');
            $address->country = $request->input('country');
            $address->save();

            // $order::update([($order->amount = $order->product->price_new)]);
            $paymentOption = $request->input('payment_option');

            // Handle the payment based on the selected option
            switch ($paymentOption) {
                case 'stripe':
                    // \Stripe\Stripe::setApiKey(
                    //     config('services.stripe.secret_key')
                    // );
                    // header('Content-Type: application/json');

                    // $YOUR_DOMAIN = 'http://localhost/shaeek/public/state';

                    // $checkout_session = \Stripe\Checkout\Session::create([
                    //     'line_items' => [
                    //         [
                    //             'price_data' => [
                    //                 'currency' => 'usd',
                    //                 'product_data' => [
                    //                     'name' => 'T-shirt',
                    //                 ],
                    //                 'unit_amount' => 2000,
                    //             ],
                    //             'quantity' => 1,
                    //         ],
                    //     ],
                    //     'mode' => 'payment',
                    //     'success_url' => 'http://shaeek.test/shaeek/ar/state',
                    //     'cancel_url' => 'http://shaeek.test/shaeek/ar/cansel',
                    // ]);
                    // header('Location: ' . $checkout_session->url);
                    // exit();
                    return $this->createStripePaymentIntent();
                    break;
                case 'paypal':
                    $payment = new PayPalPayment();

                    //pay function
                    $payment = $payment->pay(
                        600,
                        $user_id = null,
                        $user_first_name = null,
                        $user_last_name = null,
                        $user_email = null,
                        $user_phone = null,
                        $source = null
                    );
                    return redirect($payment['redirect_url']);
                    break;
                case 'paymob':
                    $payment = new PaymobPayment();
                    $payment = $payment->pay(
                        400,
                        $user_id = null,
                        $user_first_name = 'jjj',
                        $user_last_name = 'dc',
                        $user_email = 'fvcff',
                        $user_phone = '0738746648986',
                        $source = null
                    );
                    return redirect($payment['redirect_url']);

                    break;
                default:
                    return 777;
            }
        } catch (\Throwable $th) {
            print_r($th->getMessage());
            exit();
            //throw $th;
        }

        // Get the selected payment option

        // // Return a success message
        // return redirect()
        //     ->route('thankyou')
        //     ->with('success', 'Payment successful!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function state(Request $request)
    {
        dd($request);
        $string =
            $request['amount_cents'] .
            $request['created_at'] .
            $request['currency'] .
            $request['error_occured'] .
            $request['has_parent_transaction'] .
            $request['id'] .
            $request['integration_id'] .
            $request['is_3d_secure'] .
            $request['is_auth'] .
            $request['is_capture'] .
            $request['is_refunded'] .
            $request['is_standalone_payment'] .
            $request['is_voided'] .
            $request['order'] .
            $request['owner'] .
            $request['pending'] .
            $request['source_data_pan'] .
            $request['source_data_sub_type'] .
            $request['source_data_type'] .
            $request['success'];

        //     if (
        //         hash_hmac('sha512', $string, config('nafezly-payments.PAYMOB_HMAC'))
        //     ) {
        //         if ($request['success'] == 'true') {
        //             return [
        //                 'success' => true,
        //                 'payment_id' => $request['order'],
        //                 'message' => __('nafezly::messages.PAYMENT_DONE'),
        //                 'process_data' => $request->all(),
        //             ];
        //         } else {
        //             return [
        //                 'success' => false,
        //                 'payment_id' => $request['order'],
        //                 'message' => __(
        //                     'nafezly::messages.PAYMENT_FAILED_WITH_CODE',
        //                     [
        //                         'CODE' => $this->getErrorMessage(
        //                             $request['txn_response_code']
        //                         ),
        //                     ]
        //                 ),
        //                 'process_data' => $request->all(),
        //             ];
        //         }
        //     } else {
        //         return [
        //             'success' => false,
        //             'payment_id' => $request['order'],
        //             'message' => __('nafezly::messages.PAYMENT_FAILED'),
        //             'process_data' => $request->all(),
        //         ];
        //     }
        //     // dd($request);
        //     // return view('frontend.state');
    }

    public function cansel(Request $request)
    {
        // Retrieve information about the payment
        $session_id = $_GET['session_id'];
        $payment_intent = $_GET['payment_intent'];
        dd($session_id);
    }

    public function createStripePaymentIntent()
    {
        /**
         * @var \Stripe\StripeClient
         */

        \Stripe\Stripe::setApiKey(config('services.stripe.secret_key'));

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => 555,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
        ]);

      
        $intent = $paymentIntent->client_secret;

        return view('frontend.checkout_stripe', compact('intent'));
    }

    public function afterPayment(Request $request)
    {
        // echo 'Payment Received, Thanks you for using our services.';

        //   try {
        //     // Create payment
        //     $payment = new Payment();
        //     $payment
        //         ->forceFill([
        //             'order_id' => $order->id,
        //             'payment_gateway'=>
        //             'amount' => $paymentIntent->amount,
        //             'currency' => $paymentIntent->currency,
        //             'payment_status' => 'pending',
        //             'transaction_id' => $paymentIntent->id,
        //             'transaction_data' => json_encode($paymentIntent),
        //         ])
        //         ->save();
        // } catch (QueryException $e) {
        //     echo $e->getMessage();
        //     return;
        // }
        dd($request);
    }
}