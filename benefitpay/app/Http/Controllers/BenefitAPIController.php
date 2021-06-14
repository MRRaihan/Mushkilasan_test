<?php

namespace App\Http\Controllers;

require_once (__DIR__.'/../../../BenefitAPIPlugin.php');

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use iPayBenefitPipe;
use Illuminate\Support\Facades\DB;

class BenefitAPIController extends Controller
{
    public function home(Request $request) {
        $amount = $request->wallet_amt;
        $user_id = $request-> user_id;
        $chat_token = $request-> chat_token;
        $user = DB::table('users')->find($user_id);
        return view('welcome', compact('amount', 'user', 'chat_token'));
    }
    
    public function payment_request(Request $request) {
        $data =  $request->all();
        // echo "<br>";
        // print_r($data);
        //     die();
        $Pipe = new iPayBenefitPipe();

        // modify the following to reflect your "Tranportal ID", "Tranportal Password ", "Terminal Resourcekey"
        $Pipe->setid("16175952");
        $Pipe->setpassword("16175952");
        // $Pipe->setkey("10535325208510535325208510535325"); // live key
        $Pipe->setkey("10333205301510333205301510333205");

        // Do NOT change the values of the following parameters at all.
        $Pipe->setaction("1");
        $Pipe->setcardType("D");
        $Pipe->setcurrencyCode("048");

        // modify the following to reflect your pages URLs
        $Pipe->setresponseURL("https://paymentgateway.mushkilasan.com/payment_response");
        $Pipe->seterrorURL("https://paymentgateway.mushkilasan.com/payment_error");
        // not working
        // $Pipe->setresponseURL(url('/payment_request'));
        // $Pipe->seterrorURL(url('/payment_error'));

        // set a unique track ID for each transaction so you can use it later to match transaction response and identify transactions in your system and “BENEFIT Payment Gateway” portal.
        $Pipe->settrackId(substr(md5(mt_rand()), 0, 7));

        // set transaction amount
        $Pipe->setamt($data['amount']);

        // The following user-defined fields (UDF1, UDF2, UDF3, UDF4, UDF5) are optional fields.
        // However, we recommend setting theses optional fields with invoice/product/customer identification information as they will be reflected in “BENEFIT Payment Gateway” portal where you will be able to link transactions to respective customers. This is helpful for dispute cases.
        $Pipe->setudf1($data['id']);
        $Pipe->setudf2($data['name']);
        $Pipe->setudf3($data['email']);
        $Pipe->setudf4($data['mobile']);
        $Pipe->setudf5($data['chat_token']);

        $isSuccess = $Pipe->performeTransaction();
        if($isSuccess==1){
            // echo $Pipe->getresult();
            header('location:'.$Pipe->getresult());
            echo $Pipe->getresult();
        }
        else{
            echo 'Error: '.$Pipe->geterror().'<br />Error Text: '.$Pipe->geterrorText();
        }
    }

    public function payment_response(Request $request)
    {
        $trandata = isset($_POST["trandata"]) ? $_POST["trandata"] : "";
        // echo $request->all();

        if ($trandata != "")
        {
            $Pipe = new iPayBenefitPipe();

            // modify the following to reflect your "Terminal Resourcekey"
            // $Pipe->setkey("10535325208510535325208510535325"); // live key
            $Pipe->setkey("10333205301510333205301510333205");

            $Pipe->settrandata($trandata);

            $returnValue =  $Pipe->parseResponseTrandata();
            if ($returnValue == 1)
            {
                $paymentID = $Pipe->getpaymentId();
                $result = $Pipe->getresult();
                $responseCode = $Pipe->getauthRespCode();
                $transactionID = $Pipe->gettransId();
                $referenceID = $Pipe->getref();
                $trackID = $Pipe->gettrackId();
                $amount = $Pipe->getamt();
                $UDF1 = $Pipe->getudf1();
                $UDF2 = $Pipe->getudf2();
                $UDF3 = $Pipe->getudf3();
                $UDF4 = $Pipe->getudf4();
                $UDF5 = $Pipe->getudf5();
                $authCode = $Pipe->getauthCode();
                $postDate = $Pipe->gettranDate();
                $errorCode = $Pipe->geterror();
                $errorText = $Pipe->geterrorText();

                // Remove any HTML/CSS/javascrip from the page. Also, you MUST NOT write anything on the page EXCEPT the word "REDIRECT=" (in upper-case only) followed by a URL.
                // If anything else is written on the page then you will not be able to complete the process.
                if ($Pipe->getresult() == "CAPTURED")
                {
                    echo("REDIRECT=https://paymentgateway.mushkilasan.com/payment_approved");
                }
                else if ($Pipe->getresult() == "NOT CAPTURED" || $Pipe->getresult() == "CANCELED" || $Pipe->getresult() == "DENIED BY RISK" || $Pipe->getresult() == "HOST TIMEOUT")
                {
                    if ($Pipe->getresult() == "NOT CAPTURED")
                    {
                        switch ($Pipe->getAuthRespCode())
                        {
                            case "05":
                                $response = "Please contact issuer";
                                break;
                            case "14":
                                $response = "Invalid card number";
                                break;
                            case "33":
                                $response = "Expired card";
                                break;
                            case "36":
                                $response = "Restricted card";
                                break;
                            case "38":
                                $response = "Allowable PIN tries exceeded";
                                break;
                            case "51":
                                $response = "Insufficient funds";
                                break;
                            case "54":
                                $response = "Expired card";
                                break;
                            case "55":
                                $response = "Incorrect PIN";
                                break;
                            case "61":
                                $response = "Exceeds withdrawal amount limit";
                                break;
                            case "62":
                                $response = "Restricted Card";
                                break;
                            case "65":
                                $response = "Exceeds withdrawal frequency limit";
                                break;
                            case "75":
                                $response = "Allowable number PIN tries exceeded";
                                break;
                            case "76":
                                $response = "Ineligible account";
                                break;
                            case "78":
                                $response = "Refer to Issuer";
                                break;
                            case "91":
                                $response = "Issuer is inoperative";
                                break;
                            default:
                                // for unlisted values, please generate a proper user-friendly message
                                $response = "Unable to process transaction temporarily. Try again later or try using another card.";
                                break;
                        }
                    }
                    else if ($Pipe->getresult() == "CANCELED")
                    {
                        $response = "Transaction was canceled by user.";
                    }
                    else if ($Pipe->getresult() == "DENIED BY RISK")
                    {
                        $response = "Maximum number of transactions has exceeded the daily limit.";
                    }
                    else if ($Pipe->getresult() == "HOST TIMEOUT")
                    {
                        $response = "Unable to process transaction temporarily. Try again later.";
                    }
                    echo "REDIRECT=https://paymentgateway.mushkilasan.com/payment_declined";
                }
                else
                {
                    //Unable to process transaction temporarily. Try again later or try using another card.
                    echo "REDIRECT=https://paymentgateway.mushkilasan.com/error_response";
                }
            }
            else
            {
                $errorText = $Pipe->geterrorText();
            }
        }
        else if (isset($_POST["ErrorText"]))
        {
            $paymentID = $_POST["paymentid"];
            $trackID = $_POST["trackid"];
            $amount = $_POST["amt"];
            $UDF1 = $_POST["udf1"];
            $UDF2 = $_POST["udf2"];
            $UDF3 = $_POST["udf3"];
            $UDF4 = $_POST["udf4"];
            $UDF5 = $_POST["udf5"];
            $errorText = $_POST["ErrorText"];
        }
        else
        {
            $errorText = "Unknown Exception";
        }
    }
    
    public function payment_approved(Request $request) {
        $trandata = isset($_POST["trandata"]) ? $_POST["trandata"] : "";

        if ($trandata != "") {
            $Pipe = new iPayBenefitPipe();

            // modify the following to reflect your "Terminal Resourcekey"
            // $Pipe->setkey("10535325208510535325208510535325"); // live key
            $Pipe->setkey("10333205301510333205301510333205");

            $Pipe->settrandata($trandata);

            $returnValue =  $Pipe->parseResponseTrandata();
            if ($returnValue == 1)
            {
                $paymentID = $Pipe->getpaymentId();
                $result = $Pipe->getresult();
                $responseCode = $Pipe->getauthRespCode();
                $transactionID = $Pipe->gettransId();
                $referenceID = $Pipe->getref();
                $trackID = $Pipe->gettrackId();
                $amount = $Pipe->getamt();
                $user_id = $Pipe->getudf1();
                $name = $Pipe->getudf2();
                $email = $Pipe->getudf3();
                $mobile = $Pipe->getudf4();
                $chat_token = $Pipe->getudf5();
                $authCode = $Pipe->getauthCode();
                $postDate = $Pipe->gettranDate();
                $errorCode = $Pipe->geterror();
                $errorText = $Pipe->geterrorText();
                
                if ($responseCode == 0) {
                    $user = DB::table('users')->find($user_id);
                    $wallet = DB::table('wallet_table')->where('user_provider_id', $user_id)->first();
                    
                    $data = array(
                        'token' => $chat_token,
                        'currency_code' => $user->currency_code,
                        'user_provider_id' => $user_id,
                        'type' => $user->type,
                        'tokenid' => $chat_token,
                        'payment_detail' => "BenefitPay",
                        'charge_id' => 1,
                        'transaction_id' => $transactionID,
                        'exchange_rate' => 0,
                        'paid_status' => "pass",
                        'cust_id' => "self",
                        'card_id' => "self",
                        'total_amt' => $amount,
                        'fee_amt' => 0,
                        'net_amt' => $amount,
                        'amount_refund' => 0,
                        'current_wallet' => 0, // need be updated
                        'credit_wallet' => $amount,
                        'debit_wallet' => 0,
                        'avail_wallet' => $amount + ($wallet->wallet_amt ? $wallet->wallet_amt : 0),
                        'reason' => 'Wallet Top Up',
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    
                    $transaction_history_id = DB::table('wallet_transaction_history')->insertGetId($data);
                    print_r($transaction_history_id);
                    
                    if ($transaction_history_id) {
                        $updated_data = array(
                                'token' => $chat_token,
                                'currency_code' => $user->currency_code,
                                'user_provider_id' => $user_id,
                                'type' => $user->type,
                                'wallet_amt' => $amount + ($wallet->wallet_amt ? $wallet->wallet_amt : 0)
                            );
                            
                        DB::table('wallet_table')->updateOrInsert(['user_provider_id' => $user_id], $updated_data);
                    }
                }
                
            }
            else
            {
                $errorText = $Pipe->geterrorText();
            }
        }
        else if (isset($_POST["ErrorText"])) {
            $paymentID = $_POST["paymentid"];
            $trackID = $_POST["trackid"];
            $amount = $_POST["amt"];
            $id = $_POST["udf1"];
            $name = $_POST["udf2"];
            $email = $_POST["udf3"];
            $mobile = $_POST["udf4"];
            $UDF5 = $_POST["udf5"];
            $errorText = $_POST["ErrorText"];
        }
        else {
            $errorText = "Unknown Exception";
        }
        
        return view('payment_approved', compact(
            'paymentID',
            'result',
            'responseCode',
            'transactionID',
            'trackID',
            'referenceID',
            'amount',
            'name',
            'email',
            'mobile',
            'authCode',
            'postDate',
            'transaction_history_id'
        ));

        // echo "Payment ID: $paymentID";
        // echo "<br>";
        // echo "Result: $result";
        // echo "<br>";
        // echo "Response Code: $responseCode";
        // echo "<br>";
        // echo "Transaction ID: $transactionID";
        // echo "<br>";
        // echo "Reference ID: $referenceID";
        // echo "<br>";
        // echo "Track ID: $trackID";
        // echo "<br>";
        // echo "Amount: $amount";
        // echo "<br>";
        // echo $UDF1;
        // echo "<br>";
        // echo $UDF2;
        // echo "<br>";
        // echo $UDF3;
        // echo "<br>";
        // echo $UDF4;
        // echo "<br>";
        // echo $UDF5;
        // echo "<br>";
        // echo "Auth Code: $authCode";
        // echo "<br>";
        // echo "Post Date: $postDate";
        // echo "<br>";
        // echo "Error Code: $errorCode";
        // echo "<br>";
        // echo "Error Text: $errorText";
    }
    
    public function payment_declined(Request $request) {
        $trandata = isset($_POST["trandata"]) ? $_POST["trandata"] : "";

        if ($trandata != "") {
            $Pipe = new iPayBenefitPipe();

            // modify the following to reflect your "Terminal Resourcekey"
            // $Pipe->setkey("10535325208510535325208510535325"); // live key
            $Pipe->setkey("10333205301510333205301510333205");

            $Pipe->settrandata($trandata);

            $returnValue =  $Pipe->parseResponseTrandata();
            if ($returnValue == 1)
            {
                $paymentID = $Pipe->getpaymentId();
                $result = $Pipe->getresult();
                $responseCode = $Pipe->getauthRespCode();
                $transactionID = $Pipe->gettransId();
                $referenceID = $Pipe->getref();
                $trackID = $Pipe->gettrackId();
                $amount = $Pipe->getamt();
                $UDF1 = $Pipe->getudf1();
                $UDF2 = $Pipe->getudf2();
                $UDF3 = $Pipe->getudf3();
                $UDF4 = $Pipe->getudf4();
                $UDF5 = $Pipe->getudf5();
                $authCode = $Pipe->getauthCode();
                $postDate = $Pipe->gettranDate();
                $errorCode = $Pipe->geterror();
                $errorText = $Pipe->geterrorText();
                
                switch ($responseCode)
                {
                    case "05":
                        $response = "Please contact issuer";
                        break;
                    case "14":
                        $response = "Invalid card number";
                        break;
                    case "33":
                        $response = "Expired card";
                        break;
                    case "36":
                        $response = "Restricted card";
                        break;
                    case "38":
                        $response = "Allowable PIN tries exceeded";
                        break;
                    case "51":
                        $response = "Insufficient funds";
                        break;
                    case "54":
                        $response = "Expired card";
                        break;
                    case "55":
                        $response = "Incorrect PIN";
                        break;
                    case "61":
                        $response = "Exceeds withdrawal amount limit";
                        break;
                    case "62":
                        $response = "Restricted Card";
                        break;
                    case "65":
                        $response = "Exceeds withdrawal frequency limit";
                        break;
                    case "75":
                        $response = "Allowable number PIN tries exceeded";
                        break;
                    case "76":
                        $response = "Ineligible account";
                        break;
                    case "78":
                        $response = "Refer to Issuer";
                        break;
                    case "91":
                        $response = "Issuer is inoperative";
                        break;
                    default:
                        // for unlisted values, please generate a proper user-friendly message
                        $response = "Unable to process transaction temporarily. Try again later or try using another card.";
                        break;
                }
                $errorText = $response;
            }
            else
            {
                $errorText = $Pipe->geterrorText();
            }
        }
        else if (isset($_POST["ErrorText"])) {
            $paymentID = $_POST["paymentid"];
            $trackID = $_POST["trackid"];
            $amount = $_POST["amt"];
            $UDF1 = $_POST["udf1"];
            $name = $_POST["udf2"];
            $UDF3 = $_POST["udf3"];
            $UDF4 = $_POST["udf4"];
            $UDF5 = $_POST["udf5"];
            $errorText = $_POST["ErrorText"];
        }
        else {
            $errorText = "Unknown Exception";
        }
        
        return view('payment_error', compact(
            'paymentID',
            'result',
            'responseCode',
            'transactionID',
            'trackID',
            'referenceID',
            'amount',
            'UDF1',
            'UDF2',
            'UDF3',
            'authCode',
            'postDate',
            'errorCode',
            'errorText'
        ));

        //  echo "Payment ID: $paymentID";
        // echo "<br>";
        // echo "Result: $result";
        // echo "<br>";
        // echo "Response Code: $responseCode";
        // echo "<br>";
        // echo "Transaction ID: $transactionID";
        // echo "<br>";
        // echo "Reference ID: $referenceID";
        // echo "<br>";
        // echo "Track ID: $trackID";
        // echo "<br>";
        // echo "Amount: $amount";
        // echo "<br>";
        // echo $UDF1;
        // echo "<br>";
        // echo $UDF2;
        // echo "<br>";
        // echo $UDF3;
        // echo "<br>";
        // echo $UDF4;
        // echo "<br>";
        // echo $UDF5;
        // echo "<br>";
        // echo "Auth Code: $authCode";
        // echo "<br>";
        // echo "Post Date: $postDate";
        // echo "<br>";
        // echo "Error Code: $errorCode";
        // echo "<br>";
        // echo "Error Text: $errorText";
    }

    public function error()
    {
        echo "Payment ID: " . $_POST["paymentid"] . "<br />";
        echo "Track ID: " . $_POST["trackid"] . "<br />";
        echo "Amount: " . $_POST["amt"] . "<br />";
        echo "UDF 1: " . $_POST["udf1"] . "<br />";
        echo "UDF 2: " . $_POST["udf2"] . "<br />";
        echo "UDF 3: " . $_POST["udf3"] . "<br />";
        echo "UDF 4: " . $_POST["udf4"] . "<br />";
        echo "UDF 5: " . $_POST["udf5"] . "<br />";
        echo "Error Text: " . $_POST["ErrorText"] . "<br />";
    }
    
    public function error_response()
    {
        echo "<b>From Resposne Page</b>" . "<br /><br />";
        echo "Payment ID: " . $_POST["paymentid"] . "<br />";
        echo "Track ID: " . $_POST["trackid"] . "<br />";
        echo "Amount: " . $_POST["amt"] . "<br />";
        echo "UDF 1: " . $_POST["udf1"] . "<br />";
        echo "UDF 2: " . $_POST["udf2"] . "<br />";
        echo "UDF 3: " . $_POST["udf3"] . "<br />";
        echo "UDF 4: " . $_POST["udf4"] . "<br />";
        echo "UDF 5: " . $_POST["udf5"] . "<br />";
        echo "Error Text: " . $_POST["ErrorText"] . "<br />";
    }
}
