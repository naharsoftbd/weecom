<?php

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/vendor/autoload.php';


use Dashboard\Products as Products;
use Dashboard\Orders as Orders;
$products = new Products();
$orders = new Orders();

if(isset($_GET['products'])=='read'){
	if(isset($_GET['user_id'])){
		$user_id = $_GET['user_id'];
		$data = json_decode(file_get_contents("php://input"));
		return $products->createProduct($user_id,$data);
	}else{
		return $products->read();
	}
	
}
if(isset($_GET['products'])=='create'){
	if(isset($_GET['user_id'])){
		$user_id = $_GET['user_id'];
		$data = json_decode(file_get_contents("php://input"));
		return $products->createProduct($user_id,$data);
	}else{
		return $products->read();
	}
	
}

if(isset($_GET['orders'])=='read'){
	if(isset($_GET['user_id'])){
		$user_id = $_GET['user_id'];
		return $orders->getOrdersbyUser($user_id);
	}else{
		return $orders->getOrders();
	}

	
}

