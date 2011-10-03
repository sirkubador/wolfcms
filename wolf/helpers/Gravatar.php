<?php

/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2011 Martijn van der Kleijn <martijn.niji@gmail.com>
 *
 * This file is part of Wolf CMS. Wolf CMS is licensed under the GNU GPLv3 license.
 * Please see license.txt for the full license text.
 */

/**
 * A convenience helper to simplify Gravatar usage.
 *
 * @package Helpers
 *
 * @author     Martijn van der Kleijn <martijn.niji@gmail.com>
 * @copyright  Martijn van der Kleijn, 2011
 * @license    GPLv3 License <http://www.gnu.org/copyleft/gpl.txt>
 */

/**
 * Convenience helper.
 */
class Gravatar {
    private static $url = 'http://www.gravatar.com/avatar/';
    private static $surl = 'https://secure.gravatar.com/avatar/';
    private static $size = '32';
    private static $rating = 'g';
    private static $default = 'mm';
    
    public static function url($email, $size=false, $default=false, $rating=false, $secure=false) {
        $id   = md5(strtolower(trim($email)));
        
        if ($size === false) $size = self::$size;
        if ($rating === false) $rating = self::$rating;
        if ($default === false)
            $default = self::$default;
        else
            $default = urlencode ($default);
        
        return self::$url.$id.'?s='.$size.'&d='.$default.'&r='.$rating;
    }
    
    public static function surl($email, $size=false, $default=false, $rating=false) {
        return self::url($email, $size, $default, $rating, true);
    }
    
    public static function img($email, $attr = array(), $size=false, $default=false, $rating=false, $secure=false) {
        $url = self::url($email, $size, $default, $rating, $secure);
        
        $img = '<img src="' . $url . '"';
        foreach($attr as $key => $val)
            $img .= ' ' . $key . '="' . $val . '"';
        $img .= ' />';
        
        return $img;
    }
    
    public static function simg($email, $attr = array(), $size=false, $default=false, $rating=false) {
        return self::img($email, $attr, $size, $default, $rating, true);
    }
}