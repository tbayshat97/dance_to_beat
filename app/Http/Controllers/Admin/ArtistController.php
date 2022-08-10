<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ArtistStatus;
use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\ArtistProfile;
use App\Models\Dance;
use DateTime;
use App\Http\Requests\Admin\UpdateArtistRequest;
use App\Http\Requests\Admin\AddArtistRequest;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artists = Artist::all();

        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Artists"],
        ];

        $addNewBtn = "admin.artist.create";

        $pageConfigs = ['pageHeader' => true];

        return view('backend.artists.list', compact('artists', 'breadcrumbs', 'addNewBtn', 'pageConfigs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Artists"],
        ];

        $pageConfigs = ['pageHeader' => true];

        $dances = Dance::all()
        ->mapWithKeys(function ($item) {
            return [$item->id => $item->translateOrDefault()->name];
        });

        return view('backend.artists.add', compact('breadcrumbs', 'pageConfigs', 'dances'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddArtistRequest $request)
    {
        try {
            $artist = new Artist();

            if ($request->password) {
                $artist->password = bcrypt($request->password);
            }

            $artist->username = $request->username;
            $artist->is_blocked = $request->has('is_blocked') ? true : false;

            $artist->status = '2';
            $artist->save();

            $profile = new ArtistProfile();
            $profile->artist_id = $artist->id;
            $profile->dance_id = $request->dances;
            $profile->first_name = $request->first_name;
            $profile->last_name = $request->last_name;
            $profile->phone = $request->phone;
            $profile->percentage = $request->percentage;

            if ($request->birthdate) {
                $dob = DateTime::createFromFormat('d/m/Y', $request->birthdate);
                $profile->birthdate = $dob->format('Y-m-d');
            }

            $profile->bio = $request->bio;
            $profile->price_per_hour = $request->price_per_hour;
            $profile->gender = $request->gender ? intval($request->gender) : null;


            $artistGallery = [];
            $artistImage = [];

            if ($request->hasfile('gallery')) {
                foreach ($request->file('gallery') as $file) {
                    $image = uploadFile('artist', $file);
                    $artistGallery[] = saveFileUploaderMedia($image, $file, 'artist');
                }
            }

            if ($request->file('image')) {
                $image = uploadFile('artist', $request->file('image'));
                $artistImage[] = saveFileUploaderMedia($image, $request->file('image'), 'artist');
            }

            $profile->gallery = count($artistGallery) ? json_encode($artistGallery) : null;
            $profile->image = json_encode($artistImage);
            $profile->save();


            return redirect(route('admin.artist.show', $artist))->with('success', __('system-messages.add'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function show(Artist $artist)
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['link' => "admin/artist", 'name' => "Artists"], ['name' => "Update"],
        ];

        $pageConfigs = ['pageHeader' => true];

        $artistStatuses = ArtistStatus::asSelectArray();

        $dances = Dance::all()
        ->mapWithKeys(function ($item) {
            return [$item->id => $item->translateOrDefault()->name];
        });

        return view('backend.artists.profile', compact('artist', 'breadcrumbs', 'pageConfigs', 'artistStatuses', 'dances'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArtistRequest $request, Artist $artist)
    {
        try {
            if ($request->password) {
                $artist->password = bcrypt($request->password);
            }

            $artist->status = $request->status;
            $artist->profile->dance_id = $request->dances;

            $artist->profile->first_name = $request->first_name;
            $artist->profile->last_name = $request->last_name;
            $artist->profile->phone = $request->phone;

            if ($request->birthdate) {
                $dob = DateTime::createFromFormat('d/m/Y', $request->birthdate);
                $artist->profile->birthdate = $dob->format('Y-m-d');
            }

            $artist->profile->bio = $request->bio;
            $artist->profile->price_per_hour = $request->price_per_hour;
            $artist->profile->percentage = $request->percentage;
            $artist->profile->gender = $request->gender ? intval($request->gender) : null;

            if ($request->file('image')) {
                $oldImage = $artist->profile->getProfileImage();
                $image = uploadFile('artist', $request->file('image'), $oldImage);
                $artistImage[] = saveFileUploaderMedia($image,  $request->file('image'), 'artist');

                $artist->profile->image = json_encode($artistImage);
            }

            $current_images = getCurrentFileUploaderMedia($request->get('fileuploader-list-gallery'));

            $updated_images = getUpdatedFileUploaderMedia($artist->profile->gallery, $current_images);

            if ($request->hasfile('gallery')) {
                foreach ($request->file('gallery') as $file) {
                    $image = uploadFile('artist', $file);
                    $updated_images[] = saveFileUploaderMedia($image,  $file, 'artist');
                }
            }

            $artist->profile->gallery = json_encode($updated_images);
            $artist->profile->facebook_link = $request->facebook_link;
            $artist->profile->twitter_link = $request->twitter_link;
            $artist->profile->linkedin_link = $request->linkedin_link;
            $artist->profile->save();
            $artist->save();

            return redirect()->back()->with('success', __('system-messages.update'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
