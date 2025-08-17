<?php

namespace App\Http\Controllers\v1\General;

use App\Http\Controllers\Controller;
use App\Mail\AiBankSubSuccessMail;
use App\Mail\AiPaystackSubSuccessMail;
use App\Mail\AiSubscriptionSuccessMail;
use App\Mail\AiWelcomeOnboardMail;
use App\Models\Annotation;
use App\Models\Category;
use App\Models\Discount;
use App\Models\JudgementCoram;
use App\Models\JudgementSummary;
use App\Models\LawOfFederation;
use App\Models\LawOfFedPart;
use App\Models\LawOfFedSched;
use App\Models\LawOfFedSection;
use App\Models\Package;
use App\Models\Role;
use App\Models\Rule;
use App\Models\RuleCategory;
use App\Models\State;
use App\Models\SummaryRatio;
use App\Models\Team;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserTeam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class GeneralApiController extends Controller
{
    public function showJudgement(Request $request)
    {
        try {
            $judgement_summary = JudgementSummary::with('court', 'holden', 'partyAName', 'partyAType', 'partyBName', 'partyBType', 'areaOfLaw', 'judgement', 'counsels')->paginate(500);
            if (is_null($judgement_summary)) {
                return response()->json(['error' => 'Record Not Found'], 500);
            }
            foreach ($judgement_summary as $item) {
                $item->judgement_coram = JudgementCoram::where('suit_no', $item->suit_no)->get();
                $item->ratios = SummaryRatio::where('suit_no', $item->suit_no)->get();
            }
            return response(['judgement_summary' => $judgement_summary]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showLawOfFed(Request $request)
    {
        try {
            $fed = LawOfFederation::paginate(500);
            if (is_null($fed)) {
                return response()->json(['error' => 'Record Not Found'], 500);
            }
            foreach ($fed as $item) {
                $item->fed_part = LawOfFedPart::where('law_of_federation_id', $item->id)->orderBy('id', 'ASC')->get();
                $item->fed_sections = LawOfFedSection::where('law_of_federation_id', $item->id)->orderBy('id', 'ASC')->get();
                $item->fed_schedules = LawOfFedSched::where('law_of_federation_id', $item->id)->orderBy('id', 'ASC')->get();
            }
            $categories = Category::orderBy('category', 'asc')->get();

            return response(['fed' => $fed, 'categories' => $categories]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showRuleOfCourt(Request $request)
    {
        try {
            $search_param = $request->search_param;
            $rulesCategory = $request->filterByRulesCategory;
            $sections = $request->filterBySections;
            $records = Rule::when($search_param, function ($query, $search_param) {
                return $query->where('title', 'LIKE', '%' . $search_param . '%');
            })->when($rulesCategory, function ($query) use ($rulesCategory) {
                return $query->where('name', $rulesCategory);
            })->when($sections, function ($query) use ($sections) {
                return $query->where('section', $sections);
            })->orderBy('title', 'ASC')
                ->paginate(500);
            return response(['records' => $records]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // public function showRuleOfCourt(Request $request)
    // {
    //     try {
    //         if ($request->section == 'ORDERS') {
    //             $orders = Rule::where('section', 'ORDERS')->paginate(500);
    //             foreach ($orders as $item) {
    //                 $item->ruleCategory = RuleCategory::where('name', $item->name)->get();
    //                 $item->state = State::where('name', $item->name)->get();
    //             }
    //             return response(['orders' => $orders]);
    //         } elseif ($request->section == 'SCHEDULES') {
    //             $schedule = Rule::where('section', 'SCHEDULES')->paginate(500);
    //             foreach ($schedule as $item) {
    //                 $item->ruleCategory = RuleCategory::where('name', $item->name)->get();
    //                 $item->state = State::where('name', $item->name)->get();
    //             }
    //             return response(['schedule' => $schedule]);
    //         } elseif ($request->section == 'APPENDIX') {
    //             $appendix = Rule::where('section', 'APPENDIX')->paginate(500);
    //             foreach ($appendix as $item) {
    //                 $item->ruleCategory = RuleCategory::where('name', $item->name)->get();
    //                 $item->state = State::where('name', $item->name)->get();
    //             }
    //             return response(['appendix' => $appendix]);
    //         } elseif ($request->section == 'FORMS') {
    //             $form = Rule::where('section', 'FORMS')->paginate(500);
    //             foreach ($form as $item) {
    //                 $item->ruleCategory = RuleCategory::where('name', $item->name)->get();
    //                 $item->state = State::where('name', $item->name)->get();
    //             }
    //             return response(['form' => $form]);
    //         } elseif ($request->section == 'CIVIL FORMS') {
    //             $civil_form = Rule::where('section', 'CIVIL FORMS')->paginate(500);
    //             foreach ($civil_form as $item) {
    //                 $item->ruleCategory = RuleCategory::where('name', $item->name)->get();
    //                 $item->state = State::where('name', $item->name)->get();
    //             }
    //             return response(['civil_form' => $civil_form]);
    //         } elseif ($request->section == 'PROBATE FORMS') {
    //             $probate_form = Rule::where('section', 'PROBATE FORMS')->paginate(500);
    //             foreach ($probate_form as $item) {
    //                 $item->ruleCategory = RuleCategory::where('name', $item->name)->get();
    //                 $item->state = State::where('name', $item->name)->get();
    //             }
    //             return response(['probate_form' => $probate_form]);
    //         } elseif ($request->section == 'PARTS') {
    //             $part = Rule::where('section', 'PARTS')->paginate(500);
    //             foreach ($part as $item) {
    //                 $item->ruleCategory = RuleCategory::where('name', $item->name)->get();
    //                 $item->state = State::where('name', $item->name)->get();
    //             }
    //             return response(['part' => $part]);
    //         }
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

    public function packages(Request $request)
    {
        try {
            $packages = Package::whereNotNull('ai_counsel')->orderBy('created_at', 'DESC')->get();

            if ($packages->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'No packages found with AI counsel.', 'data' => []], 404);
            }

            return response()->json(['success' => true, 'message' => 'Packages retrieved successfully.', 'data' => $packages]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while retrieving packages.', 'error' => $e->getMessage()], 500);
        }
    }

    public function viewPackages($id)
    {
        try {
            $package = Package::where('id', $id)->first();

            if (!$package) {
                return response()->json(['success' => false, 'message' => 'Package not found', 'data' => []], 404);
            }

            return response()->json(['success' => true, 'message' => 'Package retrieved successfully.', 'data' => $package]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while retrieving packages.', 'error' => $e->getMessage()], 500);
        }
    }

    public function fetchUser($email)
    {
        try {
            $user = User::where('email', $email)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',
                    'data' => []
                ], 404);
            }

            // Add subscribedUser flag to the user object
            $user->subscribedUser = $user->subscribedUser();
            $user->canUseAiCounsel = $user->canUseAiCounsel();

            return response()->json([
                'success' => true,
                'message' => 'User retrieved successfully.',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving user.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    ///////////////////////////////////////checkout//////////////////////////////////
    public function checkout(Request $request)
    {
        $package = Package::where('id', $request->id)->first();
        $user = User::where('email', $request->userEmail)->first();
        return view('aicheckout', compact('package', 'user'));
    }

    public function useDiscount(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'used' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please enter a valid coupon',
                'errors' => $validator->errors()
            ], 422);
        }

        $package = Package::find($id);
        if (!$package) {
            return response()->json([
                'status' => false,
                'message' => 'Package not found.'
            ], 404);
        }

        $discount = Discount::where('package_id', $package->id)
            ->where('discount_code', $request->used)
            ->first();

        if (!$discount) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid coupon.'
            ], 400);
        }

        if ($discount->validity_end_date <= now()) {
            return response()->json([
                'status' => false,
                'message' => 'Coupon has expired.'
            ], 400);
        }

        if (is_null($discount->used) || $discount->used < $discount->usage) {
            // Update discount usage
            $discount->used = is_null($discount->used) ? 1 : $discount->used + 1;
            $discount->save();

            // Calculate discount
            $discountedAmount = ($package->price * $discount->percentage) / 100;
            $newPrice = $package->price - $discountedAmount;

            return response()->json([
                'status' => true,
                'message' => 'Discount applied successfully.',
                'data' => [
                    'original_price' => $package->price,
                    'discount_percentage' => $discount->percentage,
                    'discounted_price' => $newPrice,
                    'package' => $package,
                ]
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Coupon usage limit reached.'
        ], 400);
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */

    public function bankPayment(Request $request, $reference)
    {
        if ($request->bank_payment) {
            $fetchUser = User::where('email', $request->email)->first();
            if (!$fetchUser) {
                return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
            }

            if ($request->billingType == 'trial') {

                $previousTrial = Transaction::where('email', $request->email)->where('billing_type', 'trial')->first();

                if ($previousTrial) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'You have already used your free trial. Please subscribe to a paid plan.'
                    ], 403);
                }
            }

            $input = [
                'name' => $request->name,
                'user_id' => $fetchUser->id,
                'email' => $fetchUser->email,
                'reference' => $reference,
                'amount' => $request->amount,
                'package' => $request->package,
                'package_id' => $request->package_id,
                'status' => $request->status,
                'billing_type' => $request->billingType,
                'discounted_price' => $request->discounted_price,
            ];

            $transact = Transaction::create($input);

            $package = Package::where('id', $transact->package_id)->first();
            if ($transact->billing_type == 'paid') {
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

                $user = User::find($fetchUser->id);
                $user->package_id = $transact->package_id;
                $user->active_date = $transact_date;
                $user->expiry_date = $expiry_date;
                if ($transact->status == 'paid') {
                    $user->status = 'active';
                } else {
                    $user->status = 'inactive';
                }
                $user->save();
            } else {
                $month = $package->recur_date;
                $transact_date = $transact->created_at;
                $expiry_date =  $transact->created_at->addMonths(2);

                $user = User::find($fetchUser->id);
                $user->package_id = $transact->package_id;
                $user->active_date = $transact_date;
                $user->expiry_date = $expiry_date;
                if ($transact->status == 'paid') {
                    $user->status = 'active';
                } else {
                    $user->status = 'inactive';
                }
                $user->save();
            }

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
                'package_amount' => $package->price,
                'billing_type' => $transact->billing_type,
                'transact_date' => $transact_date,
                'expiry_date' => $expiry_date,
                'reference' => $transact->reference,
                'date' => Carbon::parse($transact->created_at)->toFormattedDateString(),
                'name' => $transact->name,
                'email' => $transact->email,
            ];
            $content = view("emails.newBankSubscriber", $newContent)->render();
            $admincontent = view("emails.notifyAdminBankSubscriber", $mainContent)->render();

            if (env('APP_ENV') == 'local') {
                $checkmail = Mail::to($explodedMail)->send(new AiBankSubSuccessMail($mainContent));
            } else {
                zohoSendMail($subject, $content, $explodedMail);
                zohoSendMail($adminsubject, $admincontent, $explodedMails); // send to admin
            }

            $this->addSubscriber($user);

            return response()->json([
                'status' => true,
                'message' => 'Payment successful',
                'data' => $transact
            ]);
        }
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
            'billing_type' => $request->billingType,
            'status' => $request->status,
            'discounted_price' => $request->discounted_price,
        ];

        Transaction::create($input);

        return response()->json([
            'status' => 'success',
            'user_id' => $request->user_id,
            'data',
            'Payment successful'
        ]);
        // $paymentDetails = Paystack::getPaymentData();
    }

    public function handleGatewayCallback($id, $reference)
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

        if ($err) {
            return response()->json([
                'status' => false,
                'message' => 'Curl error: ' . $err
            ], 500);
        }

        $new_data = json_decode($response);

        // check for Paystack failure
        if (!$new_data || !$new_data->status) {
            return response()->json([
                'status' => false,
                'message' => 'Verification failed from Paystack.',
                'paystack_response' => $new_data
            ], 400);
        }

        $transact = Transaction::where('reference', $reference)->first();
        $transact->status = 'paid';
        $transact->save();
        $package = Package::where('id', $transact->package_id)->first();

        if ($transact->billing_type == 'paid') {
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

            $user = User::find($id);
            $user->package_id = $transact->package_id;
            $user->active_date = $transact_date;
            $user->expiry_date = $expiry_date;
            if ($transact->status == 'paid') {
                $user->status = 'active';
            } else {
                $user->status = 'inactive';
            }
            $user->save();
        } else {
            $month = $package->recur_date;
            $transact_date = $transact->created_at;
            $expiry_date =  $transact->created_at->addMonths(2);

            $user = User::find($id);
            $user->package_id = $transact->package_id;
            $user->active_date = $transact_date;
            $user->expiry_date = $expiry_date;
            if ($transact->status == 'paid') {
                $user->status = 'active';
            } else {
                $user->status = 'inactive';
            }
            $user->save();
        }

        // $user->notify(new NewSubscriber($transact, $user));

        $explodedMail =  $user->email;
        $subject = 'New Subscriber';
        $newContent =  [
            'user' => $user->name,
            'package_name' => $transact->package,
            'package_price' => $transact->amount,
            'billing_type' => $transact->billing_type,
        ];
        $content = view("emails.newSubscriber", $newContent)->render();

        if (env('APP_ENV') == 'local') {
            Mail::to($explodedMail)->send(new AiPaystackSubSuccessMail($user->name, $transact->package, $transact->amount, $transact->billing_type));
        } else {
            zohoSendMail($subject, $content, $explodedMail);
        }

        $this->addSubscriber($user);

        return response()->json([
            'status' => true,
            'message' => 'Payment saved',
            'paystack' => $new_data->data ?? null
        ]);
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
            echo $response;
            $this->updateSubscriberList($response);
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
            echo $response;
            $this->updateSubscriberList($response);
        }
    }

    public function updateSubscriberList($response)
    {

        $curl = curl_init();

        $user_data = json_decode($response);
        $get_data = (array) $user_data;
        // dd($get_data);
        if (isset($get_data['contact'])) {
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
            echo $responseData;
        }
    }

    public function register(Request $request)
    {
        try {
            DB::beginTransaction();
            $validateRequest = $this->validateRegister($request);

            if ($validateRequest->fails()) {
                return response()->json(['error' => $validateRequest->errors()->first(), 'message' => $validateRequest->errors()->all()], 400);
            }

            $checkMail = User::where('email', $request->email)->first();
            if ($checkMail) {
                return response()->json(['error' => 'Email already exists'], 400);
            }

            $role = Role::where('name', 'Customer')->first();
            if (!$role) {
                return response()->json(['error' => 'Role Customer not found please contact admin'], 500);
            }

            $user = User::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'role_id' => $role->id,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'dob' => $request->dob,
                'area_of_practice' => $request->area_of_practice,
                'nba_branch' => $request->nba_branch,
                'state' => $request->state,
            ]);

            $team = Team::where('main_team', 'main')->first(); // create a column in teams table and tag it main legalpedia team
            if ($team) {
                UserTeam::create([
                    'user_id' => $user->id,
                    'team_id' => $team ? $team->id : NULL,
                    'send_request' => 1,
                    'approve_request' => 1,
                ]);
            }

            // $user->notify(new WelcomeOnboard($user));
            $explodedMail =  $user->email;
            $subject = 'Welcome Onboard!';
            $package = $request->package ? $request->package : 'trial';
            $baseUrl = (app()->environment('local') ? env('BACKEND_LOCAL_URL') : env('BACKEND_LIVE_URL'));
            $newContent =  [
                'user' => $user->name,
                'package' => $package,
                'url' => $baseUrl . '/auth/login/view',
            ];
            $content = view("emails.aiWelcomeOnboard", $newContent)->render();
            if (env('APP_ENV') == 'local') {
                Mail::to($explodedMail)->send(new AiWelcomeOnboardMail($user->name, $package, $newContent['url']));
            } else {
                zohoSendMail($subject, $content, $explodedMail);
            }
            DB::commit();
            return response()->json(['success' => true, 'user' => $user], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect Details. Please try again',
                'data' => []
            ], 404);
        }

        // $userToken = auth()->user()->createToken('API Token')->accessToken;
        $userToken = $request->user()->createToken('API Token')->plainTextToken;
        $user = User::where('id', Auth::user()->id)->with('package')->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
                'data' => []
            ], 404);
        }

        // Add subscribedUser flag to the user object
        $user->subscribedUser = $user->subscribedUser();
        $user->canUseAiCounsel = $user->canUseAiCounsel();
        $user->userToken = $userToken;

        return response()->json([
            'success' => true,
            'message' => 'User login successful.',
            'data' => $user,
            'token' => $userToken
        ]);
    }

    private function validateRegister($request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'confirm_password' => 'required|string|max:255|same:password',
            'dob' => 'required|date',
            'area_of_practice' => 'required|string|max:255',
            'nba_branch' => 'required|string|max:255',
            'state' => 'required|string|max:255',
        ];

        $validate = Validator::make($request->all(), $rules);
        return $validate;
    }
}
