<?php

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/vendor/autoload.php';

use Dashboard\DB as DB;

$entry = new DB();
echo $entry->db_num("SELECT * FROM users");