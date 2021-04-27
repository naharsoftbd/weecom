<?php 
namespace Dashboard;

use Dashboard\DB as DB;

class Users {
	protected $conn;
	private static $instance;
	public function __construct(){
		$this->conn = new DB();
	}

	public function getInstance(){
      if(!isset(Users::$instance)){
       return Users::$instance = new Users();
	   }
	}
	public function userLogedin($user_name,$password){
        
        $passwords = md5($password);
		$user_arr=array();
		$user_arr["user"]=array();
		$result = $this->conn->db_query("SELECT * from users where email='$user_name' and password='$passwords'");
		$count_row = $this->conn->db_num("SELECT * FROM users"); 
		if ($count_row> 0) {
			while ($row = $result->fetch_assoc()){

				$user_item=array(
					"id" => $row['id'],
					"user_name" => $row['display_name'],
					'email' => $row['email'],
                     "display_name" => $row['display_name'],
                     
            
				);

				array_push($user_arr["user"], $user_item);
			}

			http_response_code(200);
			echo  json_encode($user_arr);
		}else{

    // set response code - 404 Not found
			http_response_code(404);

    // tell the user no products found
			echo json_encode(
				array("message" => "No user found.")
			);
		}

	}

  public function createUser($user_name,$password){}
}