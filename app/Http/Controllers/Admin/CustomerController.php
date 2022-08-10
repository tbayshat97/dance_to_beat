<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CustomerSubscriptionStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\CustomerInterest;
use App\Models\CustomerSubscription;
use App\Models\Dance;
use DateTime;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Clients"],
        ];

        $pageConfigs = ['pageHeader' => true];

        return view('backend.customers.list', compact('customers', 'breadcrumbs', 'pageConfigs'));
    }

    public function show(Customer $customer)
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['link' => "admin/customer", 'name' => "Clients"], ['name' => "Update"]
        ];

        $pageConfigs = ['pageHeader' => true];

        $dances = Dance::all()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item->translateOrDefault()->name];
            });


        return view('backend.customers.profile', compact('customer', 'breadcrumbs', 'pageConfigs', 'dances'));
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        try {
            if ($request->password) {
                $customer->password = bcrypt($request->password);
            }

            $customer->is_blocked = $request->has('is_blocked') ? true : false;

            $customer->profile->first_name = $request->first_name;
            $customer->profile->last_name = $request->last_name;
            $customer->email = $request->email;

            if ($request->birthdate) {
                $dob = DateTime::createFromFormat('d/m/Y', $request->birthdate);
                $customer->profile->birthdate = $dob->format('Y-m-d');
            }

            $customer->profile->bio = $request->bio;
            $customer->profile->gender = $request->gender ? intval($request->gender) : null;
            $customer->profile->image = $request->hasFile('image') ? uploadFile('customer', $request->file('image'), $customer->profile->image) : $customer->profile->image;
            $customer->profile->save();
            $customer->save();

            if ($request->has('interests')) {
                foreach ($request->interests as $dance) {
                    $customerInterest = new CustomerInterest();
                    $customerInterest->customer_id = $customer->id;
                    $customerInterest->dance_id = $dance;
                    $customerInterest->save();
                }
            }

            return redirect()->back()->with('success', __('system-messages.update'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Customer $customer)
    {
        if ($customer) {
            $customer->delete();
            return redirect(route('admin.customer.index'))->with('success', __('system-messages.delete'));
        }

        return redirect(route('admin.customer.index'))->with('error', 'cutomer not found');
    }


    public function subscribers()
    {
        $subscribers = CustomerSubscription::where('status', CustomerSubscriptionStatus::Paid)->where('ends_at', '>=',  now())->get();

        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Subscribers"],
        ];

        $pageConfigs = ['pageHeader' => true];

        return view('backend.customers.subscribers-list', compact('subscribers', 'breadcrumbs', 'pageConfigs'));
    }
}
