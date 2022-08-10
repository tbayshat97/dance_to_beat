<?php

namespace App\Http\Controllers\Admin;

use App\Enums\WalkthroughType;
use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Static Pages"],
        ];

        $pageConfigs = ['pageHeader' => true];

        $staticPages = StaticPage::all();
        return view('backend.static-pages.list', compact('staticPages', 'breadcrumbs', 'pageConfigs'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StaticPage  $staticPage
     * @return \Illuminate\Http\Response
     */
    public function show(StaticPage $staticPage)
    {
        $langs = $this->lang;

        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['link' => "admin/staticPage", 'name' => "Static Pages"], ['name' => "Update"]
        ];

        return view('backend.static-pages.show', compact(['staticPage', 'langs', 'breadcrumbs']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StaticPage  $staticPage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StaticPage $staticPage)
    {
        foreach ($this->lang as $lang) {
            $validations['title_' . $lang['code']] = 'required|string';
            $validations['content_' . $lang['code']] = 'required|string';
        }

        $request->validate($validations);

        try {
            $staticPage->updated_at = now();
            $staticPage->save();

            if (!empty($staticPage)) {
                foreach ($this->lang as $lang) {
                    $staticPage->translateOrNew($lang['code'])->title = trim($request->get('title_' . $lang['code']));
                    $staticPage->translateOrNew($lang['code'])->content = trim($request->get('content_' . $lang['code']));
                    $staticPage->save();
                }
            }
            return redirect(route('admin.staticPage.show', $staticPage))->with('success', __('system-messages.update'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StaticPage  $staticPage
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaticPage $staticPage)
    {
        $staticPage->delete();
        return redirect(route('admin.staticPage.index'))->with('success', __('system-messages.delete'));
    }
}
