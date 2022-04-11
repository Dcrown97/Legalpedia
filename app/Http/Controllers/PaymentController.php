<?php

namespace App\Http\Controllers;

use Paystack;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Package;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\NewSubscriber;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewBankSubscriber;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NotifyAdminBankSubscriber;

class PaymentController extends Controller
{
    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
        try{
            return Paystack::getAuthorizationUrl()->redirectNow();
        }catch(\Exception $e) {
            return Redirect::back()->withMessage(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error']);
        }
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback($reference)
    {
        // $paymentDetails = Paystack::getPaymentData();

        // dd($paymentDetails);
        // return $reference;
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want

        $secret_key = "sk_test_42203c2028a9270bd2b33bb225010f2513eab723";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/$reference",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYHOST => 0, //because i'm on local
            CURLOPT_SSL_VERIFYPEER => 0, //because i'm on local
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer $secret_key",
            "Cache-Control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        // if ($err) {
        //     return "cURL Error #:" . $err;
        // } else {
        //     return $response;
        // }
        // return response()->json([
        //     'response'=>$response,
        // ]);
        $new_data = json_decode($response);

        $transact = Transaction::where('reference', $reference)->first();
        $transact->status = 'paid';
        $transact->save();

        $package = Package::where('id', $transact->package_id)->first();

        if($package->validity == 'Days'){
            $day = $package->recur_date;
            $transact_date = $transact->created_at;
            $expiry_date =  $transact->created_at->addDays($day);
        }
        if($package->validity == 'Months'){
            $month = $package->recur_date;
            $transact_date = $transact->created_at;
            $expiry_date =  $transact->created_at->addMonths($month);
        }
        if($package->validity == 'Years'){
            $year = $package->recur_date;
            $transact_date = $transact->created_at;
            $expiry_date =  $transact->created_at->addYears($year);
        }

        $user = User::find(auth()->id());
        $user->package_id = $transact->package_id;
        $user->active_date = $transact_date;
        $user->expiry_date = $expiry_date;
        if($transact->status == 'paid') {
            $user->status = 'active';
        } else {
            $user->status = 'inactive';
        }
        $user->save();

        $user->notify(new NewSubscriber($transact, $user));

        $this->addSubscriber($user);


        return $new_data;

    }

    public function paymentSuccess(Request $request, $reference) {
        if($request->has('bank_payment')) {
            $input = [
                'name'=> $request->name,
                'user_id'=> $request->user_id,
                'email'=> $request->email,
                'reference'=> $reference,
                'amount'=> $request->amount,
                'package'=> $request->package,
                'package_id'=> $request->package_id,
                'status'=> $request->status,
                'discounted_price'=> $request->discounted_price,
            ];

            $transact = Transaction::create($input);

            $package = Package::where('id', $transact->package_id)->first();

            if($package->validity == 'Days'){
                $day = $package->recur_date;
                $transact_date = $transact->created_at;
                $expiry_date =  $transact->created_at->addDays($day);
            }
            if($package->validity == 'Months'){
                $month = $package->recur_date;
                $transact_date = $transact->created_at;
                $expiry_date =  $transact->created_at->addMonths($month);
            }
            if($package->validity == 'Years'){
                $year = $package->recur_date;
                $transact_date = $transact->created_at;
                $expiry_date =  $transact->created_at->addYears($year);
            }

            $user = User::find(auth()->id());
            $user->package_id = $transact->package_id;
            $user->active_date = $transact_date;
            $user->expiry_date = $expiry_date;
            if($transact->status == 'paid') {
                $user->status = 'active';
            } else {
                $user->status = 'inactive';
            }
            $user->save();

            $user->notify(new NewBankSubscriber($transact, $user));

            Notification::route('mail', 'support@legalpediaonline.com')->notify(new NotifyAdminBankSubscriber($transact, $user));

            $this->addSubscriber($user);

            return redirect()->route('payment.successful', $reference);
        }
    }

    public function addSubscriber($user) {
        $data['contact'] =  [
            "email" => $user->email,
            "firstName" => $user->name,
            "lastName"=> $user->surname,
            "phone" => $user ? $user->phone : ''
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://ivendmc.api-us1.com/api/3/contacts',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => json_encode($data),
          CURLOPT_HTTPHEADER => array(
            'Api-Token: 9bb4a3a2a06332474aeb0909b0e624411f1f652e1b61be8acb80b278e0d711e92462dbea',
            'Content-Type: application/json',
            'Cookie: PHPSESSID=f5fe8b31b9008a5c64608178b66b5a27; em_acp_globalauth_cookie=df1330e2-35cc-4d82-8e34-4e6f7e895792'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        info($response);
        // return $response;

    }

    public function savePayment(Request $request, $reference) {
        $input = [
            'name'=> $request->name,
            'user_id'=> $request->user_id,
            'email'=> $request->email,
            'reference'=> $reference,
            'amount'=> $request->amount,
            'package'=> $request->package,
            'package_id'=> $request->package_id,
            'status'=> $request->status,
            'discounted_price'=> $request->discounted_price,
        ];

        Transaction::create($input);

        return response()->json([
            'status' => 'success',
            'data', 'Payment successful'
        ]);
        // $paymentDetails = Paystack::getPaymentData();
    }


    public function paymentSuccessful($reference) {
        $transaction = Transaction::where('reference', $reference)->first();

        return view('payment-success', [
            'transaction' => $transaction
        ]);
    }
}
