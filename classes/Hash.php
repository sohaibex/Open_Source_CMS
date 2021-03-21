<?php

namespace classes;

class Hash {
    public function make($string, $salt='') {
        // For password hashing we gonna use argon2 using password_hash function like the following:
        // password_hash('somepassword', PASSWORD_ARGON2I, ['memory_cost' => 2048, 'time_cost' => 4, 'threads' => 3]);
        return hash('sha256', $string . $salt);
    }

    public static function salt($length) {
        return bin2hex(random_bytes($length));
    }

    public static function unique() {
        return self::make(uniqid());
    }
}