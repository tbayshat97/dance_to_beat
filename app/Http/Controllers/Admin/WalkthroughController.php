<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Walkthrough;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class WalkthroughController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Walk-through Pages"],
        ];

        $addNewBtn = "admin.walkthrough.create";

        $pageConfigs = ['pageHeader' => true];

        $walkThroughPages = Walkthrough::all();
        return view('backend.walkThroughPages.list', compact('walkThroughPages', 'breadcrumbs', 'addNewBtn'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $langs = $this->lang;

        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['link' => "admin/walkthrough", 'name' => "Walk-through Pages"], ['name' => "Create"]
        ];

        $pageConfigs = ['pageHeader' => true];

        return view('backend.walkThroughPages.add', compact('langs', 'breadcrumbs', 'pageConfigs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($this->lang as $lang) {
            $validations['title_' . $lang['code']] = 'required|string';
            $validations['content_' . $lang['code']] = 'required|string';
        }

        $request->validate($validations);

        $walkThroughFilePath = public_path('storage/walkthrough');
        if (!File::exists($walkThroughFilePath)) {
            File::makeDirectory($walkThroughFilePath, 0777, true);
        }

        try {

            $walkThroughPage = new Walkthrough();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name  = uniqid() . '-' . time() . '.' . $image->getClientOriginalExtension();
                $image = Image::make($image)->fit(720, 1520)->save($walkThroughFilePath . '/' . $name);
                $image_name = 'walkthrough/' . $name;

                $walkThroughPage->image = $image_name;
            }

            $walkThroughPage->save();

            if (!empty($walkThroughPage)) {
                foreach ($this->lang as $lang) {
                    $walkThroughPage->translateOrNew($lang['code'])->title = trim($request->get('title_' . $lang['code']));
                    $walkThroughPage->translateOrNew($lang['code'])->content = trim($request->get('content_' . $lang['code']));
                    $walkThroughPage->save();
                }
            }

            return redirect(route('admin.walkthrough.show', $walkThroughPage->id))->with('success', __('system-messages.add'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Walkthrough  $walkthrough
     * @return \Illuminate\Http\Response
     */
    public function show(Walkthrough $walkthrough)
    {
        $langs = $this->lang;
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['link' => "admin/walkthrough", 'name' => "Walk-through Pages"], ['name' => "Update"]
        ];
        
        $pageConfigs = ['pageHeader' => true];

        return view('backend.walkThroughPages.show', compact(['walkthrough', 'langs', 'breadcrumbs', 'pageConfigs']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Walkthrough  $walkthrough
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Walkthrough $walkthrough)
    {
        foreach ($this->lang as $lang) {
            $validations['title_' . $lang['code']] = 'required|string';
            $validations['content_' . $lang['code']] = 'required|string';
        }

        $request->validate($validations);

        $walkThroughFilePath = public_path('storage/walkthrough');
        if (!File::exists($walkThroughFilePath)) {
            File::makeDirectory($walkThroughFilePath, 0777, true);
        }

        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name  = uniqid() . '-' . time() . '.' . $image->getClientOriginalExtension();
                $image = Image::make($image)->fit(720, 1520)->save($walkThroughFilePath . '/' . $name);
                $image_name = 'walkthrough/' . $name;

                $walkthrough->image = $image_name;
            }

            $walkthrough->save();

            if (!empty($walkthrough)) {
                foreach ($this->lang as $lang) {
                    $walkthrough->translateOrNew($lang['code'])->title = trim($request->get('title_' . $lang['code']));
                    $walkthrough->translateOrNew($lang['code'])->content = trim($request->get('content_' . $lang['code']));
                    $walkthrough->save();
                }
            }

            return redirect(route('admin.walkthrough.show', $walkthrough->id))->with('success', __('system-messages.update'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Walkthrough  $walkthrough
     * @return \Illuminate\Http\Response
     */
    public function destroy(Walkthrough $walkthrough)
    {
        $walkthrough->delete();
        return redirect(route('admin.walkthrough.index'))->with('success', __('system-messages.delete'));
    }
}
