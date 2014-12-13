<?php

include('password.php');

class User extends Password{


    //class used to establish connection and login connection
    //password managing is achieved by hashing


    private $db;

    //constructor
	function __construct($db){
		parent::__construct();
	
		$this->_db = $db;
	}
    //check if already logged
	public function checkIfLogged(){
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			return true;
		}		
	}

    //getting hashed password by username
	private function userHash($username){

		try {

			$stmt = $this->_db->prepare('SELECT password FROM db_members WHERE username = :username');
			$stmt->execute(array('username' => $username));
			
			$row = $stmt->fetch();
			return $row['password'];

		} catch(PDOException $e) {
		    echo '<p class="error">'.$e->getMessage().'</p>';
		}
	}

	//login function
	public function login($username,$password){	

		$hashed = $this->userHash($username);
		
		if($this->password_verify($password,$hashed) == 1){
		    
		    $_SESSION['loggedin'] = true;
		    return true;
		}		
	}
	
	//destroying session for logout
	public function logout(){
		session_destroy();
	}
	
}


?>