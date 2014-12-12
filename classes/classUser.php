<?php
require_once("../includes/config.php");
class User{

    //Class User, used for establish connection with the database, check for login, hash the password,

    private $database;

    public function __construct($database){
        $this->database = $database;
    }

    //check if already logged
    public function isLogged(){
        if(isset($_SESSION['logged']) && $_SESSION['logged'] == true){
            return true;
        }
    }

    //creating hash for password
    public function createHash($value)
    {
        return $hashPass = crypt($value, '$2a$12$'.substr(str_replace('+', '.', base64_encode(sha1(microtime(true), true))), 0, 22));
    }


    private function verify_hash($password,$hash)
    {
        return $hash == crypt($password, $hash);
    }


    private function get_user_hash($username){

        $stmt = $this->database->prepare('SELECT password FROM db_members WHERE username = :username');
        $stmt->execute(array('username' => $username));

        $row = $stmt->fetch();
        return $row['password'];

    }
    //login
    public function login($username,$password){

        $hashed = $this->get_user_hash($username);

        if($this->verify_hash($password,$hashed) == 1){

            $_SESSION['logged'] = true;
            return true;
        }
    }


}
?>