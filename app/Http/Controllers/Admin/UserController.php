<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        $administration = Auth::user();
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['link' => "admin/administration", 'name' => "Administrations"], ['name' => "Update"]
        ];
        $addNewBtn = "admin.administration.create";
        $pageConfigs = ['pageHeader' => true];

        $roles = Role::where('guard_name', 'admin')->orderBy('name')->get()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item->name];
            });

        $selected_roles = $administration->roles->pluck('id')->toArray();

        return view('backend.administrations.show', compact('administration', 'breadcrumbs', 'addNewBtn', 'pageConfigs', 'roles', 'selected_roles'));
    }

    public function updateProfile(Request $request)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
        ];

        $request->validate($rules);
        try {
            $user = Auth::user();
            $userProfile = $user->profile;

            if ($request->has('first_name')) {
                $userProfile->first_name = $request->first_name;
            }
            if ($request->has('last_name')) {
                $userProfile->last_name = $request->last_name;
            }
            $userProfile->save();

            if ($request->has('current_password') && $request->current_password) {
                $passwordRules = [
                    'current_password' => 'required',
                    'password' => 'required|min:6|confirmed'
                ];
                $request->validate($passwordRules);
                if (Hash::check($request->current_password, $user->password)) {
                    $user->fill(['password' => Hash::make($request->password)])->save();
                } else {
                    return redirect()->back()->with('error', 'You entered a worng current password !');
                }
            }

            return redirect()->route('admin.profile')->with('success', __('system-messages.update'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function index()
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Administrations"],
        ];
        $addNewBtn = "admin.administration.create";
        $pageConfigs = ['pageHeader' => true];
        $users = User::all();
        return view('backend.administrations.list', compact('users', 'breadcrumbs', 'addNewBtn', 'pageConfigs'));
    }

    public function create()
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['link' => "admin/administration", 'name' => "Administrations"], ['name' => "Create"]
        ];
        $addNewBtn = "admin.administration.create";
        $pageConfigs = ['pageHeader' => true];
        return view('backend.administrations.add', compact('breadcrumbs', 'addNewBtn', 'pageConfigs'));
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        try {
            $this->saveTodb($request->all());
            return redirect(route('admin.administration.index'))->with('success', __('system-messages.add'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'email',  'max:255', 'unique:users'],
            'password' => ['min:6', 'required', 'string', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function saveTodb(array $data)
    {
        $user = User::create([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);
        $userProfile = new UserProfile();
        $userProfile->user_id = $user->id;
        $userProfile->first_name = $data['first_name'];
        $userProfile->last_name = $data['last_name'];
        $userProfile->save();
    }

    public function show(User $administration)
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['link' => "admin/administration", 'name' => "Administrations"], ['name' => "Update"]
        ];

        $pageConfigs = ['pageHeader' => true];

        $roles = Role::where('guard_name', 'admin')->orderBy('name')->get()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item->name];
            });
        $selected_roles = $administration->roles->pluck('id')->toArray();

        return view('backend.administrations.show', compact('administration', 'breadcrumbs', 'pageConfigs', 'roles', 'selected_roles'));
    }

    public function update(Request $request, User $administration)
    {
        $validations = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => 'required|email|max:255|unique:users,username,' . $administration->id,
            'password' => 'min:6|nullable|string|confirmed',
        ];
        $request->validate($validations);

        try {
            $administration->username = $request->username;
            $administration->save();
            $administration->profile->first_name = $request->first_name;
            $administration->profile->last_name = $request->last_name;
            $administration->profile->save();
            if ($request->filled('password')) {
                $administration->password = bcrypt($request->password);
                $administration->save();
            }

            if ($request->has('roles')) {
                $selected_roles = Role::whereIn('id', $request->roles)->pluck('name')->toArray();

                // remove current roles
                foreach ($administration->roles as $value) {
                    $administration->removeRole($value);
                }

                // assign new roles
                foreach ($selected_roles as $value) {
                    $administration->assignRole($value);
                }
            }

            return redirect(route('admin.administration.show', $administration->id))->with('success', __('system-messages.update'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function destroy(User $administration)
    {
        if ($administration) {
            $administration->delete();
            return redirect(route('admin.administration.index'))->with('success', __('system-messages.delete'));
        }
    }
}
