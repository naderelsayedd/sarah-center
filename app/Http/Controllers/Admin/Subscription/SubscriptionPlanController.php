<?php 

// app/Http/Controllers/SubscriptionPlanController.php

namespace App\Http\Controllers\Admin\Subscription;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\Transcation;
use App\Http\Controllers\Controller;
use App\Models\UserSubscriptionPlan;
use App\SmCourse;
use Brian2694\Toastr\Facades\Toastr;
use App\SmNotification;
use App\Traits\NotificationSend;
use App\User;
use Illuminate\Support\Str;
use App\SmCourseCategory;
use App\SmStudentCategory;
class SubscriptionPlanController extends Controller
{
    use NotificationSend;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$categories = SmCourseCategory::where('school_id', app('school')->id)->get();
		$courseSection = SmStudentCategory::where('school_id', app('school')->id)->get();
        $subscriptionPlans = SubscriptionPlan::get();
        return view('backEnd.subscription-plans.index', compact('subscriptionPlans','categories','courseSection'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subscriptionPlan = new SubscriptionPlan();
        $subscriptionPlan->name = $request->input('name');
        $subscriptionPlan->type = $request->input('type');
        $subscriptionPlan->description = $request->input('description');
        $subscriptionPlan->price = $request->input('price');
		$subscriptionPlan->other_offers = $request->input('other_offers');
		$subscriptionPlan->number_of_student = $request->input('number_of_student');
		$subscriptionPlan->category_id = $request->input('category_id');
		$subscriptionPlan->course_section = $request->input('course_section');
		$subscriptionPlan->offer = $request->input('offer');
		$subscriptionPlan->grace_period = $request->input('grace_period');
        $subscriptionPlan->duration_type = $request->input('duration-type');
        $subscriptionPlan->save();
        Toastr::success('Subscription created successfully.', 'Success');
        return redirect()->route('subscription-plans.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = SubscriptionPlan::find($id);
        return response()->json($plan);
    }
	
	 /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plan = SubscriptionPlan::find($id);
        return response()->json($plan);
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
        $plan = SubscriptionPlan::find($id);
        $plan->name = $request->input('name');
        $plan->description = $request->input('description');
        $plan->price = $request->input('price');
        $plan->duration_type = $request->input('duration-type');
		$plan->other_offers = $request->input('other_offers');
		$plan->number_of_student = $request->input('number_of_student');
		$plan->category_id = $request->input('category_id');
		$plan->course_section = $request->input('course_section');
		$plan->offer = $request->input('offer');
		$plan->grace_period = $request->input('grace_period');
        $plan->type = $request->input('type');
        $plan->save();
        Toastr::success('Subscription updated successfully.', 'Success');
        return redirect()->back()->with('success', 'Subscription plan updated successfully!');
    }

    public function view()
    {
        $subscriptionPlan = UserSubscriptionPlan::with('subscription_plan','user')->get();
        // echo "<pre>"; print_r($subscriptionPlan);die;
        return view('backEnd.subscription-plans.view', compact('subscriptionPlan'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subscriptionPlan = SubscriptionPlan::find($id);
        $subscriptionPlan->delete();
        return redirect()->route('subscription-plans.index');
    }


    public function getSessionId(Request $request)
    {
        $environment = env('MYFATOORAH_ENVIRONMENT', 'apitest');
        $curl = curl_init();
        $url = 'https://'.$environment.'.myfatoorah.com/v2/InitiateSession';
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "SaveToken": false
        }',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$request['ApiKey'],
            'Content-Type: application/json',
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }

    public function makePayment(Request $request){
        $environment = env('MYFATOORAH_ENVIRONMENT', 'apitest');
        $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://'.$environment.'.myfatoorah.com/v2/ExecutePayment',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => json_encode($request['paymentRequest']),
              CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer CfIpeEz3XUDvT-G3CDmSjhW2iO2IILZLUkaESyqSL744Npgeg-MEs7766PnXfetBnC7cmJb_a8Sen4XOdosxTxmdJfEnFMUFzEW8NJmT7ZbRM1SWqlFFRLgSAhpY4scSfiJsF0GMj1wB87PJowJL9ZvGCHGDjc7sStIpvCEOL-GOrJQxCeI3vvDjpxoSr2JkgV6fe6tbxjhvHXLEztpHiltv9MvTNrkrwnKMrSEB2nFAibNPzT2y7naGuC0WJJUY9etFTshdbvdXRb1kZymI135s71GlHmKcSgbrE2EnT7ve2cgwEMO9oA2ugsINpaXl7HsB4GEYamXD164Dm_JthRwM2kAqfb0NLXjQ0-Um01Iu8Z-yWW0BSw6z80sS2h-HROGAzBwkiVz90VHPcLY0cHSWBI1EC2ivblPuRLIcuNVdShp7of1eWq7pmxOCHfz-GJACtzdR8ne74nYr2Qu1UO6xWhJNxVSC4DPVgH57DHouROM1hVxSArtPmtC_VcNIAJjdCHVzaL_geHAfEaUY1YGEaDvu7sIsOoWn4Oa555jjUadS-tlaEZPC4OUSsAFV2K7Y-4gAmAar4liBF1dTddC28USyV_RFJHyKvyunSBkM2du6-0arGUxJ2SDRzg9UDfFgA-wnRnKzUgbUfbvdWasFjWw-yBBskyrzkBXSm5AWgoLr',
                'Content-Type: application/json',
              ),
            ));

            $response = curl_exec($curl);
            $error = curl_error($curl);

            $responseData = json_decode($response, true);
            curl_close($curl);
            if (isset($responseData['IsSuccess']) && $responseData['IsSuccess'] === true) {  
                $responseData['request'] = $request['paymentRequest'];             
                if (isset($responseData['IsSuccess']) && $responseData['IsSuccess'] === true) {
                    /*add transaction*/
                    $userParent = session()->get('userParent');
                    $addPayment = new Transcation();
                    $addPayment->title = 'Subscription';
                    $addPayment->amount= $responseData['request']['Amount'];
                    $addPayment->payment_method= 'Myfatoorah';
                    $addPayment->user_id= $userParent->id;
                    $addPayment->transaction_date = now();
                    $addPayment->type= 'diposit';
                    $addPayment->school_id= $userParent->school_id;
                    $addPayment->academic_id= 1;
                    $addPayment->save();

                    $userSub = UserSubscriptionPlan::where('user_id', $userParent->id)->first();
                    $userSub->update([
                        'subscription_plan_id' => $request['planId']
                    ]);

                    /*verify email for user if payment is success*/
                    if ($userParent) {
                        User::where('id', $userParent->id)->where('role_id', 3)->update(['email_verify' => 1]);
                    }

                    // Notification Start
                    /*$data['title'] = "Subscription plan transaction";
                    $data['amount'] = $responseData['request']['Amount'];
                    $this->sent_notifications('Subscription_Plan', $userParent->id, $data, ['Student', 'Parent']);
                    $accounts_ids = User::where('role_id', 5)->get();
					if($accounts_ids) {
						foreach ($accounts_ids as $accounts_id) {
							$this->sendNotification($accounts_id->id, $accounts_id->role_id, "Subscription Transaction");
						}
					}*/
                    // Notification End

                    return $res = array(
                        'status' => 'success', 
                        'payment_url' => $responseData['Data']['PaymentURL']
                    );
                }else{
                    /*if payment fails send email verification mail*/
                    $userParent = session()->get('userParent');
                    $user_data = User::where('id',$userParent->id)->where('role_id',3)->first();
                    if (!empty($user_data)) {
                        $data['user_email'] = $user_data->email;
                        $data['id'] = $user_data->id;
                        $data['random'] = $user_data->random_code;
                        $data['role_id'] = 3;
                        $data['admission_number'] = "";
                            @send_mail($request->guardians_email, $request->fathers_name, "activate_account", $data);
                    }
                    return $res = array(
                        'status' => 'failed', 
                        'payment_url' => ''
                    );
                }
            }else{
                if ($error) {
                    return $error;
                }
                return false;
            }
           
    }


    public function successPayment(Request $request)
    {
        $subscriptionPlans = session()->get('subscriptionPlans');
        $subscriptionPlan = session()->get('subscriptionPlan');
        $userParent = session()->get('userParent');

        $userSubs = UserSubscriptionPlan::where('user_id',$userParent->id)->first();
        $plan = SubscriptionPlan::where('id',$userSubs->subscription_plan_id)->first();
        $currentDate = now(); // or Carbon::now() if you're using the Carbon library
        $expiryDate = now();
        if ($plan->duration_type == 1) {
            $expiryDate = $currentDate->addYear();
        } elseif ($plan->duration_type == 2) {
            $expiryDate = $currentDate->addMonths(6);
        } elseif ($plan->duration_type == 3) {
            $expiryDate = $currentDate->addMonths(3);
        } elseif ($plan->duration_type == 4) {
            $expiryDate = $currentDate->addMonth();
        }

        $daysRemaining = $expiryDate->diffInDays(now());
        $paymentId = $request->input('paymentId');
        $id = $request->input('Id');

        $data['user_email'] = $userParent->email;
        $data['id'] = $userParent->id;
        $data['amount'] = $plan->price;
        $data['role_id'] = 3;
        $data['admission_number'] = "";
        /*send email to user*/
        @send_mail($userParent->email, $userParent->full_name, "subscription_payment_success", $data);
        /*send email to admin*/
        $admin_data = User::where('role_id',1)->where('is_administrator','yes')->first();
        /*@send_mail($admin_data->email, $admin_data->full_name, "subscription_payment_success", $data);*/
        UserSubscriptionPlan::where('user_id',$userParent->id)
                            ->update([
                                'expires_at' => $expiryDate->format('Y-m-d'),
                                'is_active' => 1,
                                'transaction_id' => $id,
                                'payment_id' => $paymentId
                            ]);   
        User::where('id',$userParent->id)->where('role_id',3)->update(['subscription_plan_days_remaining' => $daysRemaining]);
        return view('errors.thankyou');
    }
}