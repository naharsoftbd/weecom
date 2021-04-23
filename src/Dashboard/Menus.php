<?php 
namespace Dashboard;

use Dashboard\Dashboard as Dashboard;


class Menus {
	public function printMenus() {
		$entry = new Dashboard();
		echo($entry->printDashboard());
	}
}
?>