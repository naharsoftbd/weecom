<?php

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/vendor/autoload.php';
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods","OPTIONS,DELETE, POST, GET");
			



use Dashboard\Products as Products;
use Dashboard\Orders as Orders;
use Dashboard\Users as Users;
$product = new Products();
$products = $product::getInstance();
$orders = new Orders();
$orders = orders::getInstance();
$users = new Users();
$user = users::getInstance();
// Product Read,Create,Update,Delete
if(isset($_GET['products'])){
if($_GET['products']=='read'){
	if(isset($_GET['user_id'])){
		$user_id = $_GET['user_id'];
		return $products->getProductsbyUser($user_id);
	}elseif(isset($_GET['id'])){
		$product_id = $_GET['id'];
		return $products->getProductsbyId($product_id);
	}else{
		return $products->read();
	}
	
}elseif($_GET['products']=='create'){
	//if(isset($_GET['user_id'])){
		//$user_id = $_POST['user_id'];
	     
		$data = json_decode(file_get_contents("php://input"));
		$user_id = $data->user_id;
		return $products->createProduct($user_id,$data);
	//}else{
	//	return $products->read();
	//}
	
}elseif($_GET['products']=='update'){
	    $data = json_decode(file_get_contents("php://input"));
		$user_id = $data->user_id;
		return $products->updateProduct($user_id,$data);
	
}elseif($_GET['products']=='delete'){
	if(isset($_GET['product_id'])){
		$product_id = $_GET['product_id'];
		return $products->deleteProduct($product_id);
	}else{
		return $products->read();
	}
}
}

// Order Read,
if(isset($_GET['orders'])){
if($_GET['orders']=='read'){
	if(isset($_GET['user_id'])){
		$user_id = $_GET['user_id'];
		return $orders->getOrdersbyUser($user_id);
	}else{
		return $orders->getOrders();
	}

}elseif($_GET['orders']=='create'){
	if(isset($_GET['user_id'])){
		$user_id = $_GET['user_id'];
		$data = json_decode(file_get_contents("php://input"));
		return $orders->createOrder($user_id,$data);
	}else{
		return $orders->getOrders();
	}
}
}

if(isset($_GET['user'])){
if($_GET['user']=='login'){
	if(isset($_GET['username']) && isset($_GET['password'])){
		return $user->userLogedin($_GET['username'],$_GET['password']);
	}
}
}

