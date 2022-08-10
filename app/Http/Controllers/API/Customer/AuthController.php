<?php

namespace App\Http\Controllers\API\Customer;

use App\Enums\GenderTypes;
use App\Enums\SourceType;
use App\Models\Customer;
use App\Models\CustomerProfile;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\ChangePasswordRequest;
use App\Http\Requests\Customer\ForgetPasswordRequest;
use App\Http\Requests\Customer\LinkSocialRequest;
use App\Http\Requests\Customer\LoginRequest;
use App\Http\Requests\Customer\ProfileRequest;
use App\Http\Requests\Customer\RegisterRequest;
use App\Http\Requests\Customer\ResendSMSRequest;
use App\Http\Requests\Customer\ResetPasswordRequest;
use App\Http\Requests\Customer\VerifySMSRequest;
use App\Http\Resources\Customer as ResourcesCustomer;
use App\Models\CustomerInterest;
use App\Models\CustomerProvider;
use App\Models\Dialog;
use App\Services\Verification;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Database\QueryException;
use Laravel\Passport\Client as OClient;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class AuthController extends Controller
{
    use ApiResponser;

    public function login(LoginRequest $request)
    {
        $http = new \GuzzleHttp\Client([
            'base_uri' => config('services.guzzle.base_url'),
        ]);

        try {
            $customer = Customer::where('username', $request->username)->whereNull('account_verified_at')->first();

            if ($customer) {
                return $this->errorResponse(205, trans('api.auth.enter_verify_code'), 400);
            }

            $customer = Customer::where('username', $request->username)->where('is_blocked', true)->first();

            if ($customer) {
                return $this->errorResponse(206, trans('api.auth.blocked'), 400);
            }

            $oClient = OClient::where('password_client', 1)->first();

            $response = $http->request('POST', config('services.passport.login_endpoint'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => $oClient->id,
                    'client_secret' => $oClient->secret,
                    'username' => $request->username,
                    'password' => $request->password,
                    'provider' => 'customers',
                    'scope' => '*',
                ],
            ]);

            $customer = Customer::where('username', $request->username)->first();


            if ($customer && $request->filled('device_id')) {
                $customer->fcm_token = $request->device_id;
                $customer->save();
            }

            $result = [
                'token' => json_decode($response->getBody())
            ];

            return $this->successResponse(200, trans('api.auth.login'), 200, $result);
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            switch ($e->getCode()) {
                case 400:
                case 401:
                    return $this->errorResponse($e->getCode(), trans('api.auth.invalid_credentials'), $e->getCode());
                    break;
                default:
                    return $this->errorResponse($e->getCode(), trans('api.public.server_error'), $e->getCode());
                    break;
            }
        }
    }

    public function register(RegisterRequest $request)
    {
        $customer = new Customer($request->all());
        $customer->username = $request->username;
        $customer->email = trim($request->email);
        $customer->password = bcrypt($request->password);
        $customer->save();

        $customerProfile = new CustomerProfile();
        $customerProfile->customer_id = $customer->id;
        $customerProfile->first_name = trim($request->first_name);
        $customerProfile->last_name = trim($request->last_name);
        $customerProfile->birthdate = $request->birthdate;
        $customerProfile->image = $request->hasFile('image') ? uploadFile('customer', $request->file('image')) : null;
        $customerProfile->source = SourceType::Normal;
        $customerProfile->save();

        $dialog = new Dialog();
        $dialog->accountable_type = Customer::class;
        $dialog->accountable_id = $customer->id;
        $dialog->save();

        try {
            $twilio = new Verification($customer->username);
            $twilio->sendSms();
        } catch (\Exception $e) {
            return $this->errorResponse(401, $e->getMessage(), 401);
        }

        return $this->successResponse(200, trans('api.auth.register'), 200, null);
    }

    public function verifySMS(VerifySMSRequest $request)
    {
        try {
            $twilio = new Verification($request->username);
            if ($twilio->verifySMS($request->verification_code)) {
                tap(Customer::where('username', $request->username))->update(['account_verified_at' => now()]);
                return $this->successResponse(200, trans('api.auth.verify_SMS_done'), 200, null);
            }
            return $this->errorResponse(401, trans('api.verification.invalid'), 401);
        } catch (\Exception $e) {
            return $this->errorResponse(401, trans('api.verification.maxAttempts'), 401);
        }
    }

    public function resendSMS(ResendSMSRequest $request)
    {
        $customer = Customer::where('username', $request->username)->first();

        try {
            $twilio = new Verification($customer->username);
            $twilio->sendSms();
        } catch (\Exception $e) {
            return $this->errorResponse(401, $e->getMessage(), 401);
        }

        return $this->successResponse(200, trans('api.auth.resent_SMS_done'), 200, null);
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $customer = Customer::where('username', $request->username)->first();

        try {
            $twilio = new Verification($customer->username);
            $twilio->sendSms();
        } catch (\Exception $e) {
            return $this->errorResponse(401, $e->getMessage(), 401);
        }

        return $this->successResponse(200, trans('api.auth.forget_password_config'), 200, null);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $customer = Customer::where('username', $request->username)->first();
        $customer->password = bcrypt($request->new_password);
        $customer->account_verified_at = date('Y-m-d H:i:s');
        $customer->save();
        return $this->successResponse(200, trans('api.auth.password_reset'), 200, null);
    }

    public function logout()
    {
        auth()->user()->token()->delete();
        return $this->successResponse(200, trans('api.auth.loggedout'), 200, null);
    }

    public function logoutFromOtherDevices()
    {
        $current_token = auth()->user()->token()->id;
        auth()->user()->tokens()->each(function ($token) use ($current_token) {
            if ($current_token != $token->id) {
                $token->delete();
            }
        });
        return $this->successResponse(200, trans('api.auth.loggedout'), 200, null);
    }

    public function profile()
    {
        return $this->successResponse(200, trans('api.public.done'), 200, new ResourcesCustomer(auth()->user()));
    }

    public function updateProfile(ProfileRequest $request)
    {
        $customer = auth()->user();

        if ($request->has('dances')) {

            $rules = [
                'dances.*' => 'required|exists:dances,id',
            ];

            $request->validate($rules);

            CustomerInterest::where('customer_id', $customer->id)->whereNotIn('dance_id', $request->dances)->delete();
            $oldCustomerInterests = $customer->interests()->count() ? $customer->interests()->pluck('dance_id')->toArray() : [];
            $allCustomerInterests = array_unique(array_merge($request->dances, $oldCustomerInterests));
            $newCustomerInterests = array_diff($allCustomerInterests, $oldCustomerInterests);

            foreach ($newCustomerInterests as $dance) {
                $customerInterest = new CustomerInterest();
                $customerInterest->customer_id = $customer->id;
                $customerInterest->dance_id = $dance;
                $customerInterest->save();
            }
        }

        $profile = $customer->profile;

        $profile->first_name = $request->has('first_name') ? trim($request->first_name) : $profile->first_name;
        $profile->last_name = $request->has('last_name') ? trim($request->last_name) : $profile->last_name;
        $profile->birthdate = $request->has('birthdate') ? $request->birthdate : $profile->birthdate;
        $profile->bio = $request->has('bio') ? $request->bio : $profile->bio;
        $profile->image = $request->hasFile('image') ? uploadFile('customer', $request->file('image'), $profile->image) : $profile->image;
        $profile->gender =  $request->has('gender') ? GenderTypes::fromValue(intval($request->gender))->value : $profile->gender;
        $profile->save();

        return $this->successResponse(200, trans('api.public.done'), 200, new ResourcesCustomer($customer));
    }

    public function updateUsername(Request $request)
    {
        $customer = auth()->user();

        $rule = [
            'username' => ['required', Rule::unique('customers')->ignore($customer->id)],
        ];

        if ($customer->username == $request->username) {
            return $this->successResponse(200, trans('api.public.done'), 200, null);
        }

        $request->validate($rule);

        $customer->username = $request->username;
        $customer->account_verified_at = null;
        $customer->save();

        try {
            $twilio = new Verification($customer->username);
            $twilio->sendSms();
        } catch (\Exception $e) {
            return $this->errorResponse(401, $e->getMessage(), 401);
        }

        return $this->successResponse(200, trans('api.public.done'), 200, null);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $customer = auth()->user();

        if (Hash::check($request->old_password, $customer->password)) {
            $customer->password = bcrypt($request->new_password);
            $customer->save();
            return $this->successResponse(200, trans('api.auth.password_updated'), 200, null);
        }

        return $this->successResponse(200, trans('api.auth.old_password_incorrect'), 200, null);
    }

    public function facebookLogin(Request $request)
    {
        $auth = app('firebase.auth');
        $facebook = $auth->signInWithFacebookAccessToken($request->facebook_token)->data();

        $providerId = trim($facebook['federatedId'], 'https://www.facebook.com/');
        $provider = CustomerProvider::where('provider_id', $providerId)->where('provider', 'facebook')->first();

        if ($provider) {

            $result = [
                'access_token' => $provider->customer->createToken(null)->accessToken,
            ];

            return $this->successResponse(200, trans('api.public.done'), 200, $result);
        } else {
            $customer = new Customer();
            $customer->username = $providerId;
            $customer->email = isset($facebook['email']) ? $facebook['email'] : null;
            $customer->password = bcrypt(Str::random(10));
            $customer->account_verified_at = now();
            $customer->fcm_token = $request->device_id;
            $customer->save();

            $provider = new CustomerProvider();
            $provider->customer_id = $customer->id;
            $provider->provider_id = $providerId;
            $provider->provider = 'face$facebook';
            $provider->save();

            $profile = new CustomerProfile();
            $profile->customer_id = $customer->id;
            $profile->first_name = $facebook['firstName'];
            $profile->last_name = $facebook['lastName'];

            $profile->source = SourceType::Facebook;
            $profile->save();

            if ($facebook['photoUrl']) {
                $customerFilePath = public_path('storage/customer');
                if (!File::exists($customerFilePath)) {
                    File::makeDirectory($customerFilePath, 0777, true);
                }

                $fileContents = file_get_contents($facebook['photoUrl']);
                $image = $fileContents;
                $name = uniqid() . '-' . time() . '.' . 'jpg';
                $image = Image::make($image)->fit(600, 600)->save($customerFilePath . '/' . $name);
                $profile->image = 'customer/' . $name;
            }

            $profile->save();

            $result = [
                'access_token' => $customer->createToken(null)->accessToken,
            ];

            return $this->successResponse(200, trans('api.public.done'), 200, $result);
        }
    }

    public function googleLogin(Request $request)
    {
        $auth = app('firebase.auth');
        $google = $auth->signInWithGoogleIdToken($request->google_token)->data();
        $providerId = trim($google['federatedId'], 'https://accounts.google.com/');
        $provider = CustomerProvider::where('provider_id', $providerId)->where('provider', 'google')->first();

        if ($provider) {
            $result = [
                'access_token' => $provider->customer->createToken(null)->accessToken,
            ];

            return $this->successResponse(200, trans('api.public.done'), 200, $result);
        } else {
            $customer = new Customer();
            $customer->username = $providerId;
            $customer->email = isset($google['email']) ? $google['email'] : null;
            $customer->password = bcrypt(Str::random(10));
            $customer->account_verified_at = now();
            $customer->fcm_token = $request->device_id;
            $customer->save();

            $provider = new CustomerProvider();
            $provider->customer_id = $customer->id;
            $provider->provider_id = $providerId;
            $provider->provider = 'google';
            $provider->save();

            $profile = new CustomerProfile();
            $profile->customer_id = $customer->id;
            $profile->first_name = $google['firstName'];
            $profile->last_name = $google['lastName'];

            $profile->source = SourceType::Google;
            $profile->save();

            $dialog = new Dialog();
            $dialog->accountable_type = Customer::class;
            $dialog->accountable_id = $customer->id;
            $dialog->save();

            if ($google['photoUrl']) {
                $customerFilePath = public_path('storage/customer');
                if (!File::exists($customerFilePath)) {
                    File::makeDirectory($customerFilePath, 0777, true);
                }

                $fileContents = file_get_contents($google['photoUrl']);
                $image = $fileContents;
                $name = uniqid() . '-' . time() . '.' . 'jpg';
                $image = Image::make($image)->fit(600, 600)->save($customerFilePath . '/' . $name);
                $profile->image = 'customer/' . $name;
            }

            $profile->save();


            $result = [
                'access_token' => $customer->createToken(null)->accessToken,
            ];

            return $this->successResponse(200, trans('api.public.done'), 200, $result);
        }
    }

    public function appleLogin(Request $request)
    {
        $providerId = $request->providerId;
        $provider = CustomerProvider::where('provider_id', $providerId)->where('provider', 'apple')->first();

        if ($provider) {

            $result = [
                'access_token' => $provider->first()->customer->createToken(null)->accessToken,
            ];

            return $this->successResponse(200, trans('api.public.done'), 200, $result);
        } else {
            $customer = new Customer();
            $customer->username = $providerId;
            $customer->password = bcrypt(Str::random(10));
            $customer->account_verified_at = now();
            $customer->fcm_token = $request->device_id;
            $customer->save();

            $provider = new CustomerProvider();
            $provider->customer_id = $customer->id;
            $provider->provider_id = $providerId;
            $provider->provider = 'apple';
            $provider->save();

            $profile = new CustomerProfile();
            $profile->customer_id = $customer->id;
            $profile->full_name = $request->first_name . ' ' . $request->last_name;
            $profile->email = $request->email;
            $profile->source = SourceType::Apple;
            $profile->save();

            $dialog = new Dialog();
            $dialog->accountable_type = Customer::class;
            $dialog->accountable_id = $customer->id;
            $dialog->save();

            $result = [
                'access_token' => $customer->createToken(null)->accessToken,
            ];

            return $this->successResponse(200, trans('api.public.done'), 200, $result);
        }
    }

    public function linkSocialAccount(LinkSocialRequest $request)
    {
        $customer = auth()->user();
        $provider = CustomerProvider::where('provider_id', $request->provider_id)
            ->where('provider', $request->provider)
            ->where('customer_id', $customer->id);

        try {
            if ($provider->count() == 0) {
                // link new account
                $provider = new CustomerProvider();
                $provider->customer_id = $customer->id;
                $provider->provider_id = $request->provider_id;
                $provider->provider = $request->provider;
                $provider->save();
            }
            return $this->successResponse(200, trans('api.public.done'), 200, new ResourcesCustomer(auth()->user()));
        } catch (QueryException $e) {
            return $this->errorResponse(200, trans('api.auth.social_exists'), 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getCode(), trans('api.public.server_error'), $e->getCode());
        }
    }

    public function checkIfNeedToUpdatePhoneNumber()
    {
        $customer = auth()->user();

        $data = [
            'customer_need_to_update_phone' => isValidNumber($customer->username) ? false : true
        ];

        return $this->successResponse(200, trans('api.public.done'), 200, $data);
    }
}
