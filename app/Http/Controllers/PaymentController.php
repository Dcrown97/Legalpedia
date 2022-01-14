<?php

namespace App\Http\Controllers;

use Paystack;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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

        $day = $package->recur_date;
        $transact_date = $transact->created_at;
        $expiry_date =  $transact->created_at->addDays($day);

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

        return $new_data;

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
}
