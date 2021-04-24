<?php 
namespace Dashboard;

use Dashboard\DB as DB;

class Orders {
	protected $conn;
	public function __construct(){
		$this->conn = new DB();
	}
	
	public function getOrders(){

		$orders_arr=array();
		$orders_arr["orders"]=array();
		$result = $this->conn->db_query("SELECT * FROM orders");
		$count_row = $this->conn->db_num("SELECT * FROM orders"); 
		if ($count_row> 0) {
			while ($row = $result->fetch_assoc()){

				$order_item=array(
					"id" => $row['id'],
					"user_id" => $row['user_id'],
            //"description" => html_entity_decode($row['description']),
           // "price" => $row['price'],
            //"category_id" => $row['category_id'],
           // "category_name" => $category_name
				);

				array_push($orders_arr["orders"], $order_item);
			}

			http_response_code(200);
			echo  json_encode($orders_arr);
		}else{

    // set response code - 404 Not found
			http_response_code(404);

    // tell the user no products found
			echo json_encode(
				array("message" => "No order found.")
			);
		}

	}
	public function getOrdersbyUser($user_id){
		$orders_arr=array();
		$orders_arr["orders"]=array();
		$result = $this->conn->db_query("SELECT * FROM orders where user_id=$user_id");
		$count_row = $this->conn->db_num("SELECT * FROM orders where user_id=$user_id"); 
		if ($count_row> 0) {
			while ($row = $result->fetch_assoc()){

				$order_item=array(
					"id" => $row['id'],
					"user_id" => $row['user_id'],
            //"description" => html_entity_decode($row['description']),
           // "price" => $row['price'],
            //"category_id" => $row['category_id'],
           // "category_name" => $category_name
				);

				array_push($orders_arr["orders"], $order_item);
			}

			http_response_code(200);
			echo  json_encode($orders_arr);
		}else{

    // set response code - 404 Not found
			http_response_code(404);

    // tell the user no products found
			echo json_encode(
				array("message" => "No order found.")
			);
		}

	

	}
}