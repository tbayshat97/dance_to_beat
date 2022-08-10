<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\RequiredIf;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        $artist = auth('artist')->user();

        $breadcrumbs = [
            ['link' => "artist", 'name' => "Dashboard"], ['link' => "artist/profile", 'name' => "Profile"], ['name' => "Update"]
        ];

        $pageConfigs = ['pageHeader' => true];

        return view('backend-artist.users.profile', compact('artist', 'breadcrumbs', 'pageConfigs'));
    }

    public function updateProfile(Request $request)
    {
        $rules = [];
        $step = intval($request->step);

        switch ($step) {
            case 1:
                $rules = [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'phone' => 'required',
                    "image" => new RequiredIf($request['fileuploader-list-image'] == json_encode([])) . '|mimes:' . config('services.allowed_file_extensions.images'),
                    "gallery.*" => 'nullable|mimes:' . config('services.allowed_file_extensions.images'),
                ];
                break;
            case 2:
                $rules = [
                    'password' => 'required|min:6|confirmed'
                ];
                break;
            case 3:
                $rules = [
                    'price_per_hour' => 'required'
                ];
                break;
            case 4:
                // for future purposes
                break;
        }

        $request->validate($rules);

        try {
            $artist = auth('artist')->user();

            if ($request->password) {
                $artist->password = bcrypt($request->password);
            }

            if ($request->has('first_name')) {
                $artist->profile->first_name = $request->first_name;
            }

            if ($request->has('last_name')) {
                $artist->profile->last_name = $request->last_name;
            }

            if ($request->has('phone')) {
                $artist->profile->phone = $request->phone;
            }

            if ($request->has('bio')) {
                $artist->profile->bio = $request->bio;
            }

            if ($request->has('price_per_hour')) {
                $artist->profile->price_per_hour = $request->price_per_hour;
            }

            if ($request->has('birthdate') && $request->birthdate) {
                $dob = DateTime::createFromFormat('d/m/Y', $request->birthdate);
                $artist->profile->birthdate = $dob->format('Y-m-d');
            }

            if ($request->has('gender')) {
                $artist->profile->gender = $request->gender ? intval($request->gender) : null;
            }

            if ($request->file('image')) {
                $oldImage = $artist->profile->getProfileImage();
                $image = uploadFile('artist', $request->file('image'), $oldImage);
                $artistImage[] = saveFileUploaderMedia($image,  $request->file('image'), 'artist');

                $artist->profile->image = json_encode($artistImage);
            }

            if ($request->has('fileuploader-list-gallery')) {
                $current_images = getCurrentFileUploaderMedia($request->get('fileuploader-list-gallery'));

                $updated_images = getUpdatedFileUploaderMedia($artist->profile->gallery, $current_images);

                if ($request->hasfile('gallery')) {
                    foreach ($request->file('gallery') as $file) {
                        $image = uploadFile('artist', $file);
                        $updated_images[] = saveFileUploaderMedia($image,  $file, 'artist');
                    }
                }
                $artist->profile->gallery = json_encode($updated_images);
            }

            if ($request->has('facebook_link')) {
                $artist->profile->facebook_link = $request->facebook_link;
            }

            if ($request->has('twitter_link')) {
                $artist->profile->twitter_link = $request->twitter_link;
            }

            if ($request->has('linkedin_link')) {
                $artist->profile->linkedin_link = $request->linkedin_link;
            }

            $artist->profile->save();
            $artist->save();

            return redirect()->back()->with('success', __('system-messages.update'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
