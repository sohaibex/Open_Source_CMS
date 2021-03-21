<?php

namespace classes;

class Session {

    // Check if there's a session variable with a specific name.
    public static function exists($name) {
        return (isset($_SESSION[$name])) ? true : false;
    }

    public static function delete($name) {
        if(self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    public static function get($name) {
        if(self::exists($name)) {
            return $_SESSION[$name];
        }

        return null;
    }

    public static function put($name, $value) {
        return $_SESSION[$name] = $value;
    }

    /*
        flash messages displayed only once to the user. If we call the flash mesthod, it will look in session array for $name value
        If this name exists it will fetch it from session, delete it, and then return it. Otherwise It gonna put it in session
    */
    public static function flash($name, $message='') {
        if(self::exists($name)) {
            $sessionData = Session::get($name);
            Session::delete($name);
            return $sessionData;
        } else {
            Session::put($name, $message);
        }
    }
}