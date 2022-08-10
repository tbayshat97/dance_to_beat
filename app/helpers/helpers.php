<?php

use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Helper
{
    public static function applClasses()
    {
        // default data value
        $dataDefault = [
            'mainLayoutType' => 'vertical-modern-menu',
            'pageHeader' => false,
            'bodyCustomClass' => '',
            'navbarLarge' => true,
            'navbarBgColor' => '',
            'isNavbarDark' => null,
            'isNavbarFixed' => true,
            'activeMenuColor' => '',
            'isMenuDark' => null,
            'isMenuCollapsed' => false,
            'activeMenuType' => '',
            'isFooterDark' => null,
            'isFooterFixed' => false,
            'templateTitle' => 'Qiotic',
            'isCustomizer' => true,
            'defaultLanguage' => 'en',
            'largeScreenLogo' => 'images/logo/materialize-logo-color.png',
            'smallScreenLogo' => 'images/logo/materialize-logo.png',
            'isFabButton' => false,
            'direction' => env('MIX_CONTENT_DIRECTION', 'ltr'),
        ];
        // if any key missing of array from custom.php file it will be merge and set a default value from dataDefault array and store in data variable
        $data = array_merge($dataDefault, config('custom.custom'));
        // all available option of materialize template
        $allOptions = [
            'mainLayoutType' => array('vertical-modern-menu', 'vertical-menu-nav-dark', 'vertical-gradient-menu', 'vertical-dark-menu', 'horizontal-menu'),
            'pageHeader' => array(true, false),
            'navbarLarge' => array(true, false),
            'isNavbarDark' => array(null, true, false),
            'isNavbarFixed' => array(true, false),
            'isMenuDark' => array(null, true, false),
            'isMenuCollapsed' => array(true, false),
            'activeMenuType' => array('sidenav-active-square' => 'sidenav-active-square', 'sidenav-active-rounded' => 'sidenav-active-rounded', 'sidenav-active-fullwidth' => 'sidenav-active-fullwidth'),
            'isFooterDark' => array(null, true, false),
            'isFooterFixed' => array(false, true),
            'isCustomizer' => array(true, false),
            'isFabButton' => array(false, true),
            'defaultLanguage' => array('en' => 'en', 'ar' => 'ar'),
            'direction' => array('ltr' => 'ltr', 'rtl' => 'rtl'),
        ];
        //if any options value empty or wrong in custom.php config file then set a default value
        foreach ($allOptions as $key => $value) {
            if (gettype($data[$key]) === gettype($dataDefault[$key])) {
                if (is_string($data[$key])) {
                    $result = array_search($data[$key], $value);
                    if (empty($result)) {
                        $data[$key] = $dataDefault[$key];
                    }
                }
            } else {
                if (is_string($dataDefault[$key])) {
                    $data[$key] = $dataDefault[$key];
                } elseif (is_bool($dataDefault[$key])) {
                    $data[$key] = $dataDefault[$key];
                } elseif (is_null($dataDefault[$key])) {
                    is_string($data[$key]) ? $data[$key] = $dataDefault[$key] : '';
                }
            }
        }
        // if any of template logo is not set or empty is set to default logo
        if (empty($data['largeScreenLogo'])) {
            $data['largeScreenLogo'] = $dataDefault['largeScreenLogo'];
        }
        if (empty($data['smallScreenLogo'])) {
            $data['smallScreenLogo'] = $dataDefault['smallScreenLogo'];
        }
        //mainLayoutTypeClass array contain default class of body element
        $mainLayoutTypeClass = [
            'vertical-modern-menu' => 'vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu 2-columns',
            'vertical-menu-nav-dark' => 'vertical-layout page-header-light vertical-menu-collapsible vertical-menu-nav-dark 2-columns',
            'vertical-gradient-menu' => 'vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu 2-columns',
            'vertical-dark-menu' => 'vertical-layout page-header-light vertical-menu-collapsible vertical-dark-menu 2-columns',
            'horizontal-menu' => 'horizontal-layout page-header-light horizontal-menu 2-columns',
        ];
        //sidenavMain array contain default class of sidenav
        $sidenavMain = [
            'vertical-modern-menu' => 'sidenav-main nav-expanded nav-lock nav-collapsible',
            'vertical-menu-nav-dark' => 'sidenav-main nav-expanded nav-lock nav-collapsible navbar-full',
            'vertical-gradient-menu' => 'sidenav-main nav-expanded nav-lock nav-collapsible gradient-45deg-deep-purple-blue sidenav-gradient ',
            'vertical-dark-menu' => 'sidenav-main nav-expanded nav-lock nav-collapsible',
            'horizontal-menu' => 'sidenav-main nav-expanded nav-lock nav-collapsible sidenav-fixed hide-on-large-only',
        ];
        //sidenavMainColor array contain sidenav menu's color class according to layout types
        $sidenavMainColor = [
            'vertical-modern-menu' => 'sidenav-light',
            'vertical-menu-nav-dark' => 'sidenav-light',
            'vertical-gradient-menu' => 'sidenav-dark',
            'vertical-dark-menu' => 'sidenav-dark',
            'horizontal-menu' => '',
        ];
        //activeMenuTypeClass array contain active menu class of sidenav according to layout types
        $activeMenuTypeClass = [
            'vertical-modern-menu' => 'sidenav-active-square',
            'vertical-menu-nav-dark' => 'sidenav-active-rounded',
            'vertical-gradient-menu' => 'sidenav-active-rounded',
            'vertical-dark-menu' => 'sidenav-active-rounded',
            'horizontal-menu' => '',
        ];
        //navbarMainClass array contain navbar's default classes
        $navbarMainClass = [
            'vertical-modern-menu' => 'navbar-main navbar-color nav-collapsible no-shadow nav-expanded sideNav-lock',
            'vertical-menu-nav-dark' => 'navbar-main navbar-color nav-collapsible sideNav-lock gradient-shadow',
            'vertical-gradient-menu' => 'navbar-main navbar-color nav-collapsible sideNav-lock',
            'vertical-dark-menu' => 'navbar-main navbar-color nav-collapsible sideNav-lock',
            'horizontal-menu' => 'navbar-main navbar-color nav-collapsible sideNav-lock',
        ];
        //navbarMainColor array contain navabar's color classes according to layout types
        $navbarMainColor = [
            'vertical-modern-menu' => 'navbar-dark gradient-45deg-indigo-purple',
            'vertical-menu-nav-dark' => 'navbar-dark gradient-45deg-purple-deep-orange',
            'vertical-gradient-menu' => 'navbar-light',
            'vertical-dark-menu' => 'navbar-light',
            'horizontal-menu' => 'navbar-dark gradient-45deg-light-blue-cyan',
        ];
        //navbarLargeColor array contain navbarlarge's default color classes
        $navbarLargeColor = [
            'vertical-modern-menu' => 'gradient-45deg-indigo-purple',
            'vertical-menu-nav-dark' => 'blue-grey lighten-5',
            'vertical-gradient-menu' => 'blue-grey lighten-5',
            'vertical-dark-menu' => 'blue-grey lighten-5',
            'horizontal-menu' => 'blue-grey lighten-5',
        ];
        //mainFooterClass array contain Footer's default classes
        $mainFooterClass = [
            'vertical-modern-menu' => 'page-footer footer gradient-shadow',
            'vertical-menu-nav-dark' => 'page-footer footer gradient-shadow',
            'vertical-gradient-menu' => 'page-footer footer',
            'vertical-dark-menu' => 'page-footer footer',
            'horizontal-menu' => 'page-footer footer gradient-shadow',
        ];
        //mainFooterColor array contain footer's color classes
        $mainFooterColor = [
            'vertical-modern-menu' => 'footer-dark gradient-45deg-indigo-purple',
            'vertical-menu-nav-dark' => 'footer-dark gradient-45deg-purple-deep-orange',
            'vertical-gradient-menu' => 'footer-light',
            'vertical-dark-menu' => 'footer-light',
            'horizontal-menu' => 'footer-dark gradient-45deg-light-blue-cyan',
        ];
        //  above arrary override through dynamic data
        $layoutClasses = [
            'mainLayoutType' => $data['mainLayoutType'],
            'mainLayoutTypeClass' => $mainLayoutTypeClass[$data['mainLayoutType']],
            'sidenavMain' => $sidenavMain[$data['mainLayoutType']],
            'navbarMainClass' => $navbarMainClass[$data['mainLayoutType']],
            'navbarMainColor' => $navbarMainColor[$data['mainLayoutType']],
            'pageHeader' => $data['pageHeader'],
            'bodyCustomClass' => $data['bodyCustomClass'],
            'navbarLarge' => $data['navbarLarge'],
            'navbarLargeColor' => $navbarLargeColor[$data['mainLayoutType']],
            'navbarBgColor' => $data['navbarBgColor'],
            'isNavbarDark' => $data['isNavbarDark'],
            'isNavbarFixed' => $data['isNavbarFixed'],
            'activeMenuColor' => $data['activeMenuColor'],
            'isMenuDark' => $data['isMenuDark'],
            'sidenavMainColor' => $sidenavMainColor[$data['mainLayoutType']],
            'isMenuCollapsed' => $data['isMenuCollapsed'],
            'activeMenuType' => $data['activeMenuType'],
            'activeMenuTypeClass' => $activeMenuTypeClass[$data['mainLayoutType']],
            'isFooterDark' => $data['isFooterDark'],
            'isFooterFixed' => $data['isFooterFixed'],
            'templateTitle' => $data['templateTitle'],
            'isCustomizer' => $data['isCustomizer'],
            'largeScreenLogo' => $data['largeScreenLogo'],
            'smallScreenLogo' => $data['smallScreenLogo'],
            'defaultLanguage' => $allOptions['defaultLanguage'][$data['defaultLanguage']],
            'mainFooterClass' => $mainFooterClass[$data['mainLayoutType']],
            'mainFooterColor' => $mainFooterColor[$data['mainLayoutType']],
            'isFabButton' => $data['isFabButton'],
            'direction' => $data['direction'],
        ];
        // set default language if session hasn't locale value the set default language
        if (!session()->has('locale')) {
            app()->setLocale($layoutClasses['defaultLanguage']);
        }
        return $layoutClasses;
    }
    // updatesPageConfig function override all configuration of custom.php file as page requirements.
    public static function updatePageConfig($pageConfigs)
    {
        $demo = 'custom';
        $custom = 'custom';
        if (isset($pageConfigs)) {
            if (count($pageConfigs) > 0) {
                foreach ($pageConfigs as $config => $val) {
                    Config::set($demo . '.' . $custom . '.' . $config, $val);
                }
            }
        }
    }
}

if (!function_exists('getHeaderLang')) {
    /**
     * Read HTTP_ACCEPT_LANGUAGE from header
     *
     * @return string
     */
    function getHeaderLang()
    {
        !empty(request()->server('HTTP_ACCEPT_LANGUAGE')) ? $lang = request()->server('HTTP_ACCEPT_LANGUAGE') : $lang = 'en';
        return $lang;
    }
}

if (!function_exists('getUserTokenFromBearerToken')) {
    /**
     * get the user access_token from bearer token;
     *
     * To get the user by the token, you need to understand what the token is.
     * The token is broken up into three base64 encoded parts: the header, the payload, and the signature,
     * separated by periods.
     * In your case, since you're just wanting to find the user, you just need the header
     *
     * @author Abdulkareem Tubishat <kareem@qiotic.com>
     * @param string $bearer_token Bearer xxxxxxxx
     * @return string user token
     */
    function getUserTokenFromBearerToken($bearer_token)
    {
        try {
            $auth_header = explode(' ', $bearer_token);
            $token = $auth_header[1];

            // break up the token into its three respective parts
            $token_parts = explode('.', $token);
            $token_header = $token_parts[1];

            // base64 decode to get a json string
            $token_header_json = base64_decode($token_header);
            $token_header_array = json_decode($token_header_json, true);
            $user_token = $token_header_array['jti'];
            return $user_token;
        } catch (\Exception $e) {
            return null;
        }
    }
}

if (!function_exists('getUserFromAccessToken')) {
    /**
     * get the user row from mathcing class;
     *
     * @author Abdulkareem Tubishat <kareem@qiotic.com>
     * @param string $access_token
     * @return string user
     */
    function getUserFromAccessToken($access_token)
    {
        try {
            $result = DB::table('oauth_access_tokens')->where('id', $access_token)->first();
            if ($result)
                return $result->user_id;
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}

if (!function_exists('uploadFile')) {
    /**
     * Upload File to local storage
     *
     * @author Abdulkareem Tubishat <kareem@qiotic.com>
     * @param string $folder_name folder name in storage folder
     * @param mixed $file file in request EX: $request->file('image')
     * @param string|null $old_file old file name to delete it from storage
     * @return string new file name with path in storage
     */
    function uploadFile($folder_name, $file, $old_file = null)
    {
        $filePath = public_path('storage/' . $folder_name);
        if (!File::exists($filePath)) {
            File::makeDirectory($filePath, 0777, true);
        }
        $name = uniqid() . '-' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs($folder_name, $name, 'public');

        if (!is_null($old_file)) {
            Storage::delete('public/' . $old_file);
        }
        return $folder_name . '/' . $name;
    }
}

if (!function_exists('isValidNumber')) {
    function isValidNumber($username)
    {
        return (preg_match("/^\s*962/i", $username)) ? true : false;
    }
}

if (!function_exists('allMonths')) {
    function allMonths()
    {
        return [
            'January' => 1,
            'February' => 2,
            'March' => 3,
            'April' => 4,
            'May' => 5,
            'June' => 6,
            'July' => 7,
            'August' => 8,
            'September' => 9,
            'October' => 10,
            'November' => 11,
            'December' => 12
        ];
    }
}

if (!function_exists('starRatingsCalculator')) {
    /**
     * get the rate of object
     *
     * @author Abdulkareem Tubishat <kareem@qiotic.com>
     * @param class $type
     * @param integer $id
     * @return array
     */
    function starRatingsCalculator($type, $id)
    {
        $rows = Review::where('reviewable_type', $type)->where('reviewable_id', $id)->get();

        $notes = [];
        $values = [
            'rate_1' => 0,
            'rate_2' => 0,
            'rate_3' => 0,
            'rate_4' => 0,
            'rate_5' => 0,
        ];
        foreach ($rows as $value) {
            $values['rate_' . $value->rate] = $values['rate_' . $value->rate] + 1;
            $notes[] = $value->note;
        }

        $sum_result =
            (1 * $values['rate_1']) +
            (2 * $values['rate_2']) +
            (3 * $values['rate_3']) +
            (4 * $values['rate_4']) +
            (5 * $values['rate_5']);

        $count_result = $values['rate_1'] + $values['rate_2'] + $values['rate_3'] + $values['rate_4'] + $values['rate_5'];
        if ($count_result == 0) {
            $total = 0;
        } else {
            $total = $sum_result / $count_result;
        }

        return [
            'notes' => $notes,
            'users' => $values,
            'total' => number_format($total, 1),
        ];
    }
}

if (!function_exists('get_percentage')) {
    /**
     * get percentage betwwen two numbers
     *
     * @author Abdulkareem Tubishat <kareem@qiotic.com>
     * @param class $type
     * @param integer $id
     * @return array
     */
    function get_percentage($total, $number)
    {
        if ($total > 0) {
            return round($number / $total * 100);
        } else {
            return 0;
        }
    }
}

if (!function_exists('saveFileUploaderMedia')) {
    /**
     * get file uploader data
     *
     * @author Abdulkareem Tubishat <kareem@qiotic.com>
     * @param class $type
     * @param integer $id
     * @return array
     */
    function saveFileUploaderMedia($image, $file, $fileName)
    {
        return [
            'file' => $image,
            'name' => ltrim($image, $fileName . '/'),
            'size' => filesize($file),
            'local' => $image,
            'type' => filetype($file),
            'data' => [
                'url' => $image,
                'thumbnail' => $image,
                'readerForce' => true
            ],
        ];
    }
}


if (!function_exists('getFileUploaderMedia')) {
    /**
     * get file uploader data
     *
     * @author Abdulkareem Tubishat <kareem@qiotic.com>
     * @param class $type
     * @param integer $id
     * @return array
     */
    function getFileUploaderMedia($jsonData)
    {
        $data = [];
        if ($jsonData) {
            foreach (json_decode($jsonData) as  $value) {
                $value->file = asset('storage') . '/' . $value->file;
                $value->type = 'image/jpeg';
                $value->local = asset('storage') . '/' . $value->local;
                $value->data->url = asset('storage') . '/' . $value->data->url;
                $value->data->thumbnail  = asset('storage') . '/' . $value->data->thumbnail;

                $data[] = $value;
            }
        }

        return json_encode($data);
    }
}

if (!function_exists('getCurrentFileUploaderMedia')) {
    /**
     * get file uploader data
     *
     * @author Abdulkareem Tubishat <kareem@qiotic.com>
     * @param class $type
     * @param integer $id
     * @return array
     */
    function getCurrentFileUploaderMedia($jsonData)
    {
        $current_images = [];
        foreach (json_decode($jsonData) as $key => $value) {
            if (!Str::startsWith($value->file, '0:/')) {
                $current_images[] = str_replace(asset('storage') . '/', "", $value->file);
            }
        }

        return $current_images;
    }
}

if (!function_exists('getUpdatedFileUploaderMedia')) {
    /**
     * get file uploader data
     *
     * @author Abdulkareem Tubishat <kareem@qiotic.com>
     * @param class $type
     * @param integer $id
     * @return array
     */
    function getUpdatedFileUploaderMedia($jsonData, $current_images)
    {
        $updated_images = [];
        foreach (json_decode($jsonData) as $value) {
            if (!in_array($value->file, $current_images)) {
                Storage::delete('public/' . $value->file);
            } else {
                $updated_images[] = $value;
            }
        }
        return $updated_images;
    }
}


if (!function_exists('getRandomColor')) {
    /**
     * get file uploader data
     *
     * @author Abdulkareem Tubishat <kareem@qiotic.com>
     * @param class $type
     * @param integer $id
     * @return array
     */
    function getRandomColor()
    {
        $rand = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'g'];

        $color = '#' . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)];

        return $color;
    }
}
