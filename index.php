<?php

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/vendor/autoload.php';
header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Headers: *");
			



use Dashboard\Products as Products;
use Dashboard\Orders as Orders;
$product = new Products();
$products = $product::getInstance();
$orders = new Orders();
// Product Read,Create,Update,Delete
if(isset($_GET['products'])){
if($_GET['products']=='read'){
	if(isset($_GET['user_id'])){
		$user_id = $_GET['user_id'];
		return $products->getProductsbyUser($user_id);
	}else{
		return $products->read();
	}
	
}elseif($_GET['products']=='create'){
	if(isset($_GET['user_id'])){
		$user_id = $_GET['user_id'];
		$data = json_decode(file_get_contents("php://input"));
		return $products->createProduct($user_id,$data);
	}else{
		return $products->read();
	}
	
}elseif($_GET['products']=='update'){
	if(isset($_GET['user_id'])){
		$user_id = $_GET['user_id'];
		$data = json_decode(file_get_contents("php://input"));
		return $products->updateProduct($user_id,$data);
	}else{
		return $products->read();
	}
	
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

