<?php 
namespace Dashboard;

use Dashboard\DB as DB;

class Products {
   protected $conn;
   public $id;
   public $name;
   public $description;
   public $price;
   public $category_id;
   public $category_name;
   public $created;
   private static $instance;
   
   public function __construct(){
      $this->conn = new DB();
  }

  public function getInstance(){
      if(!isset(Products::$instance)){
       return Products::$instance = new Products();
   }
}



public function read(){
  $products_arr=array();
  $products_arr["products"]=array();
  $result = $this->conn->db_query("SELECT * FROM products");
  $count_row = $this->conn->db_num("SELECT * FROM products"); 
  if ($count_row> 0) {
      while ($row = $result->fetch_assoc()){
       
        $product_item=array(
            "id" => $row['id'],
            "name" => $row['name'],
            "description" => html_entity_decode($row['description']),
            "price" => $row['price'],
            "category_id" => $row['category_id'],
           "image" => $row['image']
        );
        
        array_push($products_arr["products"], $product_item);
    }

    http_response_code(200);
    echo  json_encode($products_arr);
}else{
  
    // set response code - 404 Not found
    http_response_code(404);
    
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}
}
public function getProductsbyUser($user_id){
  $products_arr=array();
  $products_arr["products"]=array();
  $result = $this->conn->db_query("SELECT * FROM products where created_by=$user_id");
  $count_row = $this->conn->db_num("SELECT * FROM products where created_by=$user_id"); 
  if ($count_row> 0) {
      while ($row = $result->fetch_assoc()){
       
        $product_item=array(
            "id" => $row['id'],
            "name" => $row['name'],
            "description" => html_entity_decode($row['description']),
            "price" => $row['price'],
            "category_id" => $row['category_id'],
           // "category_name" => $category_name
        );
        
        array_push($products_arr["products"], $product_item);
    }

    http_response_code(200);
    echo  json_encode($products_arr);
}else{
  
    // set response code - 404 Not found
    http_response_code(404);
    
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}
}
public function createProduct($user_id,$data){
	// make sure data is not empty

    if(
        !empty($data->name) &&
        !empty($data->price) &&
        !empty($data->description) &&
        !empty($data->category_id)
    ){ 

    // set product property values
        
     $product = $this->conn->db_query("INSERT INTO `products` (`name`, `sku`, `description`, `category_id`, `price`, `image`, `created_by`, `updated_by`) VALUES ('$data->name', $data->sku, '$data->description', $data->category_id, $data->price, '', $user_id, $user_id);");

    // create the product
     if($product){
      
        // set response code - 201 created
        http_response_code(201);
        
        // tell the user
        echo json_encode(array("message" => "Product was created."));
    }
    
    // if unable to create the product, tell the user
    else{
      
        // set response code - 503 service unavailable
        http_response_code(503);
        
        // tell the user
        echo json_encode(array("message" => "Unable to create product."));
    }
}  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
    
    // tell the user
    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}
}

public function updateProduct($user_id,$data){
    // make sure data is not empty

    if(
        !empty($data->name) &&
        !empty($data->price) &&
        !empty($data->description) &&
        !empty($data->category_id)
    ){ 

    // set product property values
        
     $product = $this->conn->db_query("UPDATE `products` SET `name`= '$data->name',`sku` = $data->sku, `description` = '$data->description',`category_id` = $data->category_id, `price` = $data->price, `image` = '', `created_by` = $user_id, `updated_by` = $user_id WHERE `products`.`id` = $data->id;");

    // create the product
     if($product){
      
        // set response code - 201 created
        http_response_code(201);
        
        // tell the user
        echo json_encode(array("message" => "Product was updated."));
    }
    
    // if unable to create the product, tell the user
    else{
      
        // set response code - 503 service unavailable
        http_response_code(503);
        
        // tell the user
        echo json_encode(array("message" => "Unable to Update product."));
    }
}  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
    
    // tell the user
    echo json_encode(array("message" => "Unable to update product. Data is incomplete."));
}
}
public function deleteProduct($product_id){

    $product = $this->conn->db_query("DELETE FROM `products` WHERE `products`.`id` = $product_id");
    if($product){
      
        // set response code - 201 created
        http_response_code(201);
        
        // tell the user
        echo json_encode(array("message" => "Product successfully deleted."));
    }else{
        // set response code - 400 bad request
        http_response_code(400);
        
    // tell the user
        echo json_encode(array("message" => "Unable to delete product. Process is incomplete."));
    }

}
}
?>