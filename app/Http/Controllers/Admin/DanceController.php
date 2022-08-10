<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddDanceRequest;
use App\Http\Requests\Admin\UpdateDanceRequest;
use App\Models\Dance;

class DanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dances = Dance::all();

        $langs = $this->lang;

        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Dances"],
        ];

        $addNewBtn = "admin.dance.create";

        $pageConfigs = ['pageHeader' => true];

        return view('backend.dances.list', compact('dances', 'langs', 'pageConfigs', 'breadcrumbs', 'addNewBtn'));
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
            ['link' => "admin", 'name' => "Dashboard"], ['link' => "admin/dance", 'name' => "Dances"], ['name' => "Create"]
        ];

        $pageConfigs = ['pageHeader' => true];

        return view('backend.dances.add', compact(['langs', 'pageConfigs', 'breadcrumbs']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddDanceRequest $request)
    {
        try {
            $dance = new Dance();

            $dance->image = $request->hasFile('image') ? uploadFile('dance', $request->file('image')) : null;
            $dance->is_active = ($request->has('is_active')) ? true : false;
            $dance->save();

            foreach ($this->lang as $lang) {
                $dance->translateOrNew($lang['code'])->name = trim($request->get('name_' . $lang['code']));
                $dance->save();
            }

            return redirect(route('admin.dance.show', $dance))->with('success', __('system-messages.add'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dance  $dance
     * @return \Illuminate\Http\Response
     */
    public function show(Dance $dance)
    {
        $langs = $this->lang;

        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['link' => "admin/dance", 'name' => "Dances"], ['name' => "Update"]
        ];

        return view('backend.dances.show', compact(['dance', 'langs', 'breadcrumbs']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dance  $dance
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDanceRequest $request, Dance $dance)
    {
        try {
            $dance->image = $request->hasFile('image') ? uploadFile('dance', $request->file('image'), $dance->image) : $dance->image;
            $dance->is_active = ($request->has('is_active')) ? true : false;
            $dance->save();

            foreach ($this->lang as $lang) {
                $dance->translateOrNew($lang['code'])->name = trim($request->get('name_' . $lang['code']));
                $dance->save();
            }

            return redirect(route('admin.dance.show', $dance))->with('success', __('system-messages.add'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dance  $dance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dance $dance)
    {
        $dance->delete();

        return redirect(route('admin.dance.index'))->with('success', __('system-messages.delete'));
    }
}
