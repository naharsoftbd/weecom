<?php 
namespace Dashboard;

use Dashboard\DB as DB;

class Orders {
	protected $conn;
	private static $instance;
	public function __construct(){
		$this->conn = new DB();
	}
	
	public function getInstance(){
      if(!isset(Orders::$instance)){
       return Orders::$instance = new Orders();
	   }
	}
	public function getOrders(){

		$orders_arr=array();
		$orders_arr["orders"]=array();
		$result = $this->conn->db_query("SELECT *,os.status as order_status FROM orders as o inner join order_items as oi on o.id=oi.order_id inner join products as p on p.id = oi.product_id
			INNER JOIN order_status as os on os.id = o.order_status
			INNER JOIN users as us on us.id = o.user_id");
		$count_row = $this->conn->db_num("SELECT * FROM orders"); 
		if ($count_row> 0) {
			while ($row = $result->fetch_assoc()){

				$order_item=array(
					"id" => $row['id'],
					"user_name" => $row['display_name'],
					'product_name' => $row['name'],
                     "price" => $row['order_price'] * $row['qty'],
                     "quentaty" =>$row['qty'],
                     "order_status" =>$row['order_status'],
            
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
		$result = $this->conn->db_query("SELECT * FROM orders as o inner join order_items as oi on o.id=oi.order_id inner join products as p on p.id = oi.product_id where o.user_id=$user_id");
		$count_row = $this->conn->db_num("SELECT * FROM orders where user_id=$user_id"); 
		if ($count_row> 0) {
			while ($row = $result->fetch_assoc()){

				$order_item=array(
					"id" => $row['id'],
					"user_id" => $row['user_id'],
					'product_name' => $row['name'],
                     "price" => $row['order_price'] * $row['qty'],
                     "quentaty" =>$row['qty'],
            
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

  public function createOrder($user_id,$data){
  	if(
        !empty($data->product_id) &&
        !empty($data->product_qty)
    ){ 

    // set product property values
        
     $order = $this->conn->db_query("INSERT INTO `orders` (`user_id`, `order_status`) VALUES ($user_id, 1);");
     $last_order_id = $this->conn->insert_id;
     $order_item = $this->conn->db_query("INSERT INTO `order_items` (`product_id`, `order_price`, `qty`, `order_id`) VALUES ($data->product_id, $data->order_price, $data->product_qty,$last_order_id);");

    // create the product
     if($order){
      
        // set response code - 201 created
        http_response_code(201);
        
        // tell the user
        echo json_encode(array("message" => "Order was created."));
    }
    
    // if unable to create the product, tell the user
    else{
      
        // set response code - 503 service unavailable
        http_response_code(503);
        
        // tell the user
        echo json_encode(array("message" => "Unable to create Order."));
    }
}  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
    
    // tell the user
    echo json_encode(array("message" => "Unable to create Order. Data is incomplete."));
}

  }
}