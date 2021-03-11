<?php

require_once realpath(__DIR__ . '/vendor/autoload.php');

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$endpoint = $_ENV['DB_ENDPOINT'];
$user = $_ENV['DB_USER'];
$password = $_ENV['DB_PASSWORD'];
$schema = $_ENV['DB_SCHEMA'];

$connect=mysqli_connect($endpoint,$user,$password,$schema);

if (!$connect) {
	die("Connection failed: " . mysqli_connect_error());
}