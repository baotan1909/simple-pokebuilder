<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$frontend = $_ENV['FRONTEND_URL'];

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: $frontend");
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Credentials: true');

if (isset($_SESSION['user'])) {
  echo json_encode(['user' => $_SESSION['user']]);
} else {
  http_response_code(401);
  echo json_encode(['error' => 'Not logged in']);
}