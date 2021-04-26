<?php 
namespace Dashboard;

class DB {
	  private $host;
	  private $user;
	  private $pass;
	  private $db;
	  private $mysqli;
    public $insert_id;
	  public function __construct() {
	    $this->db_connect();
	  }
	public function printdb() {
		return "DB Connected";
	}

	private function db_connect(){
    $this->host = 'localhost';
    $this->user = 'root';
    $this->pass = '';
    $this->db = 'wedevs';

    $this->mysqli = new \mysqli($this->host, $this->user, $this->pass, $this->db);
    return $this->mysqli;
  }
  public function db_num($sql){
        $result = $this->mysqli->query($sql);
        return $result->num_rows;
  }
  public function db_query($sql){
        $results = $this->mysqli->query($sql);
        $this->insert_id = $this->mysqli->insert_id; 
        return $results;
  }
}
?>