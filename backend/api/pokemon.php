<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$frontend = $_ENV['FRONTEND_URL'];

header("Access-Control-Allow-Origin: $frontend");
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

$cacheDuration = $_ENV['CACHE_DURATION'];
$cacheDir = __DIR__ . '/' . ($_ENV['CACHE_DIR']);
$cacheFile = "$cacheDir/pokemon_gen1.json";

if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheDuration)) {
    echo file_get_contents($cacheFile);
    exit;
}

$url = "https://pokeapi.co/api/v2/generation/1";

$response = file_get_contents($url);
if ($response === FALSE) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch Pokémon from PokeAPI']);
    exit;
}

file_put_contents($cacheFile, $response);

echo $response;