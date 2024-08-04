<?php

class speed_up_asset
{
    public static function getUrl($file, $show_timestamp = true)
    {
        if ($show_timestamp) {
            $timestamp = '?timestamp=' . @filemtime(rex_path::assets($file));
        }

        return rex_url::assets($file) . $timestamp;
    }

    public static function showUrl($file, $show_timestamp = true)
    {
        echo self::getUrl($file, $show_timestamp);
    }
}
