<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$origin = $_ENV['FRONTEND_ORIGIN'];

header("Access-Control-Allow-Origin: $origin");
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

$baseUrl = $_ENV['POKEAPI_BASE_URL'];
$cacheDuration = $_ENV['CACHE_DURATION'];
$cacheDir = __DIR__ . '/' . ($_ENV['CACHE_DIR']);

if (!isset($_GET['name'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing Pokémon name or ID']);
    exit;
}

$name = strtolower(trim($_GET['name']));
$cacheFile = "$cacheDir/pokemon_$name.json";

@mkdir($cacheDir);

if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheDuration)) {
    echo file_get_contents($cacheFile);
    exit;
}

$url = "$baseUrl/pokemon/$name";
$response = @file_get_contents($url);

if ($response === FALSE) {
    http_response_code(404);
    echo json_encode(['error' => "Pokémon '$name' not found"]);
    exit;
}

file_put_contents($cacheFile, $response);
echo $response;