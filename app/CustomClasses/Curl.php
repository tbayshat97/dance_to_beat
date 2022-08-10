<?php

namespace App\CustomClasses;

/**
 * A fully class which can make a curl request of any PHP version.
 * @author Ammar Midani <ammar.midani.1994@gmail.com>
 */
class Curl
{
    protected static $url;
    protected static $headers;
    protected static $query;
    protected static $responses;
    protected static $status_code;

    /**
     * @param $url
     * @param $headers
     * @param $query
     */
    public static function prepare($url, $query, $headers = [])
    {
        self::$url = $url;
        self::$headers = $headers;
        self::$query = $query;
    }

    /**
     *  Execute post method curl request
     */
    public static function exec_post()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, self::$url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, self::$headers);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, self::$query);
        self::$responses = curl_exec($curl);
        self::$status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
    }

    public static function exec_put()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, self::$url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, self::$headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($curl, CURLOPT_POSTFIELDS, self::$query);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        self::$responses = curl_exec($curl);
        self::$status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
    }

    public static function exec_delete()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, self::$url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, self::$headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        self::$responses = curl_exec($curl);
        self::$status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
    }

    /**
     *  Execute get method curl request
     */
    public static function exec_get()
    {
        $full_url = self::$url . '?' . self::$query;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $full_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, self::$headers);
        self::$responses = curl_exec($curl);
        self::$status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
    }

    /**
     * @return mixed
     */
    public static function get_response()
    {
        return [
            'code' => self::$status_code,
            'data' => self::$responses,
        ];
    }

    /**
     * @return mixed
     */
    public static function get_response_assoc()
    {
        return [
            'code' => self::$status_code,
            'data' => json_decode(self::$responses, true),
        ];
    }
}
