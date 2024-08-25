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
        try {
            return Paystack::getAuthorizationUrl()->redirectNow();
        } catch (\Exception $e) {
            return Redirect::back()->withMessage(['msg' => 'The paystack token has expired. Please refresh the page and try again.', 'type' => 'error']);
        }
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback($reference)
    {

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

        $new_data = json_decode($response);

        $transact = Transaction::where('reference', $reference)->first();
        $transact->status = 'paid';
        $transact->save();

        $package = Package::where('id', $transact->package_id)->first();

        if ($package->validity == 'Days') {
            $day = $package->recur_date;
            $transact_date = $transact->created_at;
            $expiry_date =  $transact->created_at->addDays($day);
        }
        if ($package->validity == 'Months') {
            $month = $package->recur_date;
            $transact_date = $transact->created_at;
            $expiry_date =  $transact->created_at->addMonths($month);
        }
        if ($package->validity == 'Years') {
            $year = $package->recur_date;
            $transact_date = $transact->created_at;
            $expiry_date =  $transact->created_at->addYears($year);
        }

        $user = User::find(auth()->id());
        $user->package_id = $transact->package_id;
        $user->active_date = $transact_date;
        $user->expiry_date = $expiry_date;
        if ($transact->status == 'paid') {
            $user->status = 'active';
        } else {
            $user->status = 'inactive';
        }
        $user->save();

        // $user->notify(new NewSubscriber($transact, $user));

        $explodedMail =  $user->email;
        $subject = 'New Subscriber';
        $newContent =  [
            'user' => $user->name,
            'package_name' => $transact->package,
            'package_price' => $transact->amount,
        ];
        $content = view("emails.newSubscriber", $newContent)->render();
        zohoSendMail($subject, $content, $explodedMail);

        $this->addSubscriber($user);

        return $new_data;
    }

    public function paymentSuccess(Request $request, $reference)
    {
        if ($request->has('bank_payment')) {
            $input = [
                'name' => $request->name,
                'user_id' => $request->user_id,
                'email' => $request->email,
                'reference' => $reference,
                'amount' => $request->amount,
                'package' => $request->package,
                'package_id' => $request->package_id,
                'status' => $request->status,
                'discounted_price' => $request->discounted_price,
            ];

            $transact = Transaction::create($input);

            $package = Package::where('id', $transact->package_id)->first();

            if ($package->validity == 'Days') {
                $day = $package->recur_date;
                $transact_date = $transact->created_at;
                $expiry_date =  $transact->created_at->addDays($day);
            }
            if ($package->validity == 'Months') {
                $month = $package->recur_date;
                $transact_date = $transact->created_at;
                $expiry_date =  $transact->created_at->addMonths($month);
            }
            if ($package->validity == 'Years') {
                $year = $package->recur_date;
                $transact_date = $transact->created_at;
                $expiry_date =  $transact->created_at->addYears($year);
            }

            $user = User::find(auth()->id());
            $user->package_id = $transact->package_id;
            $user->active_date = $transact_date;
            $user->expiry_date = $expiry_date;
            if ($transact->status == 'paid') {
                $user->status = 'active';
            } else {
                $user->status = 'inactive';
            }
            $user->save();

            // $user->notify(new NewBankSubscriber($transact, $user));

            // Notification::route('mail', 'support@legalpediaonline.com')->notify(new NotifyAdminBankSubscriber($transact, $user));

            $explodedMail =  $user->email;
            $explodedMails =  'support@legalpediaonline.com';
            $subject = 'Purchase Successful';
            $adminsubject = 'New Subscriber';
            $newContent =  [
                'user' => $user->name,
                'package_name' => $transact->package,
                'package_price' => $transact->amount,
                'reference' => $transact->reference,
                'date' => Carbon::parse($transact->created_at)->toFormattedDateString(),
                'name' => $transact->name,
                'email' => $transact->email,
            ];
            $mainContent =  [
                'user' => $user->name,
                'user_surname' => $user->surname,
                'package_name' => $transact->package,
                'package_price' => $transact->amount,
                'reference' => $transact->reference,
                'date' => Carbon::parse($transact->created_at)->toFormattedDateString(),
                'name' => $transact->name,
                'email' => $transact->email,
            ];
            $content = view("emails.newBankSubscriber", $newContent)->render();
            $admincontent = view("emails.notifyAdminBankSubscriber", $mainContent)->render();
            zohoSendMail($subject, $content, $explodedMail); // send to user
            tribearcSendMail($adminsubject, $admincontent, $explodedMails); // send to admin

            $this->addSubscriber($user);

            return redirect()->route('payment.successful', $reference);
        }
    }

    public function addSubscriber($user)
    {
        $package = Package::where('id', $user->package_id)->first();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://ivendmc.api-us1.com/api/3/contacts?status=-1&email=' . $user->email,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Api-Token: 9bb4a3a2a06332474aeb0909b0e624411f1f652e1b61be8acb80b278e0d711e92462dbea',
                'Cookie: PHPSESSID=04a10f3af56b8443eaf4b634cee35999; em_acp_globalauth_cookie=b8b1817d-ee1b-46ba-9abc-746bff155ede'
            ),
        ));

        $response = curl_exec($curl);

        $user_data = json_decode($response);

        $get_data = (array) $user_data;

        if (isset($get_data['contacts']) && !empty($get_data['contacts'])) { // if the user already exists in active campaign update the user's details
            $data['contact'] =  [
                "email" => $user->email,
                "firstName" => $user->name,
                "lastName" => $user->surname,
                "phone" => $user->phone,
                "fieldValues" => [
                    [
                        "field" => 16, // subscription field id on active campaign
                        "value" => $package->name
                    ],
                    [
                        "field" => 15, // validity date field id on active campaign for expiry date for package
                        "value" => $user->expiry_date
                    ]
                ]
            ];
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://ivendmc.api-us1.com/api/3/contacts/' . $get_data['contacts'][0]->id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'PUT',
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
            return $this->updateSubscriberList($response);
        } else { // if the user doesn't exist create the user

            $data['contact'] =  [
                "email" => $user->email,
                "firstName" => $user->name,
                "lastName" => $user->surname,
                "phone" => $user ? $user->phone : '',
                "fieldValues" => [
                    [
                        "field" => 16, // subscription field id on active campaign
                        "value" => $package->name
                    ],
                    [
                        "field" => 15, // validity date field id on active campaign for expiry date for package
                        "value" => $user->expiry_date
                    ]
                ]
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
            return $this->updateSubscriberList($response);
        }
    }

    public function updateSubscriberList($response)
    {

        $curl = curl_init();

        $user_data = json_decode($response);
        $get_data = (array) $user_data;
        $data['contactList'] =  [
            "list" => 117,
            "contact" => $get_data['contact']->id,
            "status" => 1
        ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://ivendmc.api-us1.com/api/3/contactLists',
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
                'Cookie: PHPSESSID=d09ae0ba781b73250bc06560910257e5; em_acp_globalauth_cookie=784f19ac-a870-4d9b-8cf1-bb74c2b2478e'
            ),
        ));

        $responseData = curl_exec($curl);

        curl_close($curl);
        info($responseData);
    }

    public function savePayment(Request $request, $reference)
    {
        $input = [
            'name' => $request->name,
            'user_id' => $request->user_id,
            'email' => $request->email,
            'reference' => $reference,
            'amount' => $request->amount,
            'package' => $request->package,
            'package_id' => $request->package_id,
            'status' => $request->status,
            'discounted_price' => $request->discounted_price,
        ];

        Transaction::create($input);

        return response()->json([
            'status' => 'success',
            'data',
            'Payment successful'
        ]);
        // $paymentDetails = Paystack::getPaymentData();
    }


    public function paymentSuccessful($reference)
    {
        $transaction = Transaction::where('reference', $reference)->first();

        return view('payment-success', [
            'transaction' => $transaction
        ]);
    }
}
