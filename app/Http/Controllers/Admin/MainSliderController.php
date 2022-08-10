<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainSlider;
use Illuminate\Http\Request;

class MainSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "MainSlider"],
        ];

        $pageConfigs = ['pageHeader' => true];

        $addNewBtn = "admin.app-slider.create";


        $appSlider = MainSlider::all();

        return view('backend.appSlider.list', compact('appSlider', 'breadcrumbs','addNewBtn'));
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
            ['link' => "admin", 'name' => "Dashboard"], ['link' => "admin/app-slider", 'name' => "MainSlider"], ['name' => "Create"]
        ];

        $pageConfigs = ['pageHeader' => true];

        return view('backend.appSlider.add', compact('langs', 'breadcrumbs', 'pageConfigs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $appSlider = new MainSlider();

            foreach ($this->lang as $lang) {
                $appSlider->image = $request->hasFile('image') ? uploadFile('mainSlider', $request->file('image')) : null;
                $appSlider->translateOrNew($lang['code'])->content = trim($request->get('content_' . $lang['code']));
                $appSlider->save();
            }

            return redirect(route('admin.app-slider.show', $appSlider->id))->with('success', __('system-messages.add'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MainSlider  $appSlider
     * @return \Illuminate\Http\Response
     */
    public function show(MainSlider $appSlider)
    {
        $langs = $this->lang;

        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['link' => "admin/app-slider", 'name' => "Main Slider"], ['name' => "Update"]
        ];
        $pageConfigs = ['pageHeader' => true];

        return view('backend.appSlider.show', compact(['appSlider', 'langs', 'breadcrumbs', 'pageConfigs']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MainSlider  $appSlider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MainSlider $appSlider)
    {
        try {
            foreach ($this->lang as $lang) {
                $appSlider->image = $request->hasFile('image') ? uploadFile('mainSlider', $request->file('image'), $appSlider->image) : $appSlider->image;
                $appSlider->type = $request->type;
                $appSlider->product_id = $request->product;
                $appSlider->translateOrNew($lang['code'])->content = trim($request->get('content_' . $lang['code']));
                $appSlider->save();
            }

            return redirect(route('admin.app-slider.show', $appSlider->id))->with('success', __('system-messages.update'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MainSlider  $mainSlider
     * @return \Illuminate\Http\Response
     */
    public function destroy(MainSlider $appSlider)
    {
        $appSlider->delete();
        return redirect(route('admin.app-slider.index'))->with('success', __('system-messages.delete'));
    }
}
