<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\LicensedUserSession;

function highlightText($str, $search_term)
{
    if (empty($search_term))
        return $str;

    $pos = strpos(strtolower($str), strtolower($search_term));

    if ($pos !== false) {
        $replaced = substr($str, 0, $pos);
        $replaced .= '<mark>' . substr($str, $pos, strlen($search_term)) . '</mark>';
        $replaced .= substr($str, $pos + strlen($search_term));
    } else {
        $replaced = $str;
    }
    return $replaced;
}



function returnHighlightText($str, $search_term)
{
    if (empty($search_term))
        return false;

    $pos = strpos(strtolower($str), strtolower($search_term));

    if ($pos !== false) {
        return true;
    } else {
        return false;
    }
}

if (!function_exists('getRating')) {
    function getRating($rating)
    {
        if ($rating > 0 && $rating < 2) {
            echo ("<i class='mdi mdi-star text-warning'></i>");
        } else if ($rating > 1 && $rating < 3) {
            echo ("<i class='mdi mdi-star text-warning'></i><i class='mdi mdi-star text-warning'></i>");
        } else if ($rating > 2 && $rating < 4) {
            return "<i class='mdi mdi-star text-warning'></i><i class='mdi mdi-star text-warning'></i></i><i class='mdi mdi-star text-warning'></i>";
        } else if ($rating > 3 && $rating < 5) {
            echo ("<i class='mdi mdi-star text-warning'></i><i class='mdi mdi-star text-warning'></i></i><i class='mdi mdi-star text-warning'></i><i class='mdi mdi-star text-warning'></i>");
        } else if ($rating == 5) {
            echo ("<i class='mdi mdi-star text-warning'></i><i class='mdi mdi-star text-warning'></i><i class='mdi mdi-star text-warning'></i><i class='mdi mdi-star text-warning'></i><i class='mdi mdi-star text-warning'></i>");
        }
    }
}

if (!function_exists('tribearcMail')) {
    function tribearcMail($subject, $content, $mails)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://mail.tribearc.com/api/campaigns/send_email.php');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); //
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST'); //
        curl_setopt($curl, CURLOPT_POSTFIELDS, array(
            'api_key' => 'eaMwfGpPoFAgvUVnJjWkXYOrBDIuNd',
            'from_name' => 'Legalpedia',
            'from_email' => 'legalpediapro@gmail.com',
            'reply_to' => 'legalpediapro@gmail.com',
            'subject' => $subject,
            'html_text' => $content,
            'track_opens' => '1',
            'track_clicks' => '1',
            'send_campaign' => '1',
            'json' => '1',
            'emails' => $mails,
            'business_address' => 'Plot A4 Justice Coker Estate, CBD Alausa, Ikeja, Lagos Nigeria.',
            'business_name' => 'Legalpedia'
        ));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Api-Token: eaMwfGpPoFAgvUVnJjWkXYOrBDIuNd'));

        $response = curl_exec($curl);
        $res = json_decode($response);
        curl_close($curl);
    }
}

if (!function_exists('zohoSendMail')) {
    function zohoSendMail($subject, $content, $mails)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://mail.tribearc.com/api/campaigns/send_now.php');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); //
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST'); //
        curl_setopt($curl, CURLOPT_POSTFIELDS, array(
            'api_key' => 'eaMwfGpPoFAgvUVnJjWkXYOrBDIuNd',
            'from_name' => 'Legalpedia',
            'from_email' => 'legalpediapro@tribearc.net',
            'reply_to' => 'legalpediapro@gmail.com',
            'subject' => $subject,
            'html_text' => $content,
            'track_opens' => '1',
            'track_clicks' => '1',
            'send_campaign' => '1',
            'json' => '1',
            'emails' => $mails,
            'business_address' => 'Plot A4 Justice Coker Estate, CBD Alausa, Ikeja, Lagos Nigeria.',
            'business_name' => 'Legalpedia'
        ));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Api-Token: eaMwfGpPoFAgvUVnJjWkXYOrBDIuNd'));

        $response = curl_exec($curl);
        // dd($response);
        $res = json_decode($response);
        curl_close($curl);
    }
}

function zohoSendMail($subject, $content, $mails)
{
    $curl = curl_init();
    $postData = json_encode([
        "from" => ["address" => "noreply@legalpediaresources.com"],
        "to" => [["email_address" => ["address" => $mails]]],
        "subject" => $subject,
        "htmlbody" => $content,
    ]);

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.zeptomail.com/v1.1/email",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_HTTPHEADER => array(
            "accept: application/json",
            "authorization: Zoho-enczapikey " . env('ZEPTO_MAIL_API_KEY'),
            "cache-control: no-cache",
            "content-type: application/json",
        ),
        CURLOPT_SSL_VERIFYPEER => false, // Disable SSL verification
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        // Handle error
        echo "cURL Error #:" . $err;
    } else {
        // Handle success
        echo $response;
    }
}

function checkUser()
{
    //check if I've been bounced by another user
    $exist = Session::get('who');
    $user = Auth::user();
    $license_code = isset($user->license_code);
    if ($license_code) {
        $bounced = LicensedUserSession::where('session_no', $exist)->first();
        if (!$bounced) {
            Auth::logout();
            return false;
        }
    }
    return true;
}
