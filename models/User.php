<?php

namespace models;
use classes\{DB, Hash, Config, Session};

class User {
    private $db = null;
    private $is_logged_in = false;
    private $user_session = null;
    private $cookie = null;
    /*
        Notice when we fetch a user all the fields in the users table will be inserted as associative array of key/value pairs;
        So even if we change our table schema, our user model will still work fine !
    */
    private $model = [];

    // ---- constructor ----
    public function __construct($id='') {
        $this->db = DB::getInstance();
        $this->user_session = Config::get('session/session_name');
        $this->cookie = Config::get('remember/cookie_name');

        // First we check if a session exists
        if(Session::exists($this->user_session)) {
            // If it does, we fetch the id from it
            $user_id = Session::get($this->user_session);
            // and compare it with the provided id; if they match each others that's mean the user is currently logged in
            if($id == $user_id) {
                $this->is_logged_in = true;
            }
        }

        if($id != '') {
            $data = $this->db->query("SELECT * FROM users WHERE id = ?", [$id]);
    
            // Check user's existance
            if(count($data->results())) {
                // Store fetched user inside user_obj variable
                $user_obj = $data->results()[0];
                // Then we extract its model in the current User model
                foreach($user_obj as $key=>$value) {
                    $this->model[$key] = $value;
                }
            }   
        }
    }

    public function get($property) {
        return $this->$property;
    }

    public function set($property, $value) {
        $this->$property = $value;
    }

    public static function fetch($id) {
        return self::fetch_by('id', $id);
    }
    
    public static function fetch_by($property, $value) {
        $db = DB::getInstance();

        // First check if both property and value are not empty
        if($property != '' && $value != '') {
            // Fetch user record
            $data = $db->query("SELECT * FROM users WHERE $property = ?", [$value]);
    
            // Check user's existance
            if(count($data->results())) {
                // Store fetched user inside temp_user variable
                $user_obj = $data->results()[0];
                // We want to return User model object, not an StdObject
                $user = new User();
                $model = [];
                foreach($user_obj as $key=>$value) {
                    $model[$key] = $value;
                }
                $user->set("model", $model);
                return $user;
            }

            return false;
        }

        return false;
    }

    public static function fetch_all() {
        return DB::getInstance()->query('SELECT * FROM users')->results();
    }

    public static function login($email_or_username, $password, $remember=false) {
        // First we create a user
        $user = new User();
        //Then we check which option (username or email) does the user choose
        $property = "username";
        if(strpos($email_or_username, "@")) {
            $property = "email";
        }

        // First we chck if the email or username exists in our records
        if($u = self::fetch_by($property, $email_or_username)) {
            // Fetch original hashed password along with salt and id
            $user_id = ($u->get('model'))['id'];
            $original_password = ($u->get('model'))['password'];
            $salt = ($u->get('model'))['salt'];

            // Then we check if the passwords match or not
            if($original_password === Hash::make($password, $salt)) {
                Session::put($this->user_session, $user_id);
                
                /* 
                This will only executed if user's credentials are correct and he checks remember me: We generate a hash, 
                check if the hash is not  already exists in user_session table and insert that hash into the database;
                What happens is the user store a cookie with id and a hash and also the app store these infos in database
                Next time the user visit the app we need to check if he has a cookie that identifies it, if so we compare the hash of it with hash in db
                */
                if($remember) {
                    $db = DB::getInstance();
                    $db->query("SELECT * FROM `sessions` WHERE user = ?", $user_id);
                    
                    // If this user is not exists in sessions table
                    if(!$db->count()) {
                        $hash = Hash::unique();
                        $db->query('INSERT INTO `sessions` (user, hash) VALUES (?, ?)', 
                            array($user_id, $hash));
                    } else {
                        // If the user does exist we get his hash
                        $hash = $this->db->results()[0]->hash;
                    }

                    Cookie::put($this->cookieName, $hash, Config::get("remember/cookie_expiry"));
                }
                return $user;
            }
        }
        return false;
    }

    public function logout() {

        $this->db->query("DELETE FROM `sessions` WHERE user = ?", [($this->get('model'))['id']]);

        Session::delete($this->sessionName);
        Session::delete(Config::get("session/tokens/logout"));
        Cookie::delete($this->cookieName);
    }
}