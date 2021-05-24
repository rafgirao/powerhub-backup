<?php

namespace App\Services;

use Alaouy\Youtube\Facades\Youtube;
use Exception;


class Deeplink
{
    /**
     * @return string
     */
    public function getDevice(): string
    {
        $iphone = strpos($_SERVER['HTTP_USER_AGENT'], "iPhone");
        $ipad = strpos($_SERVER['HTTP_USER_AGENT'], "iPad");
        $ipod = strpos($_SERVER['HTTP_USER_AGENT'], "iPod");
        $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

        if ($iphone or $ipad or $ipod) {
            return 'iOS';
        }

        if ($android) {
            return 'Android';
        }

        return 'Other';
    }

    /**
     * @param $link
     * @return string
     */
    public function getSocial($link): string
    {
        if (strpos($link, 'instagram')) {
            return 'ig';
        }

        if (strpos($link, 'youtube')) {
            return 'yt';
        }

        return 'Other';
    }

    /**
     * @param $link
     * @return string
     */
    public function instagramUrlPrepare($link): string
    {
        if (strpos($link, '/p/') or strpos($link, '/tv/')) {
            return 'roolback';
        }

        $uri = str_replace(['https://', 'http://', 'www.instagram.com/', 'instagram.com/'], '', $link);
        $uri = explode('/', $uri);

        if ($uri[0] === "" or strpos($uri[0], "instagram.com")) {
            return 'roolback';
        }

        $uri = $uri[0] . ((isset($uri[1]) and $uri[1]) !== "" ? '/' . $uri[1] : null);
        return $uri;
    }

    /**
     * @param $link
     * @return string
     * @throws Exception
     */
    public function youtubeUrlPrepare($link): string
    {
        if (strpos($link, 'watch') or strpos($link, 'youtu.be')) {
            return 'watch?v=' . Youtube::parseVidFromURL($link);
        }

        return str_replace(['https://', 'http://', 'www.youtube.com/', 'youtube.com/'], '', $link);
    }

    public function realIp()
    {
       $ip = $_SERVER['REMOTE_ADDR'];
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
            foreach ($matches[0] AS $xip) {
                if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                    $ip = $xip;
                    break;
                }
            }
        } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        } elseif (isset($_SERVER['HTTP_X_REAL_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_X_REAL_IP'])) {
            $ip = $_SERVER['HTTP_X_REAL_IP'];
        }
        return $ip;
    }
}
