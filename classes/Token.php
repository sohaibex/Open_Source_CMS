<?php

namespace classes;

class Token {
    /*
        The following function generate a token by storing it inside a session, and then return it.
        
    */
    public static function generate($token_name) {
        return Session::put($token_name, md5(uniqid()));
    }

    /*
        The following function will check if the token_name token exists in session; if it does, it will also check if the provided 
        token matches the token inside the sesion; If they match we delete the session and return true which means fine.
        If they don't match we simply return false;
    */

    public static function check($token, $token_name) {
        if(Session::exists($token_name) && $token === Session::get($token_name)) {
            Session::delete($token_name);
            return true;
        }

        return false;
    }
}