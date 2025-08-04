<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$frontend = $_ENV['FRONTEND_URL'];

header("Access-Control-Allow-Origin: $frontend");
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

if (!is_dir($cacheDir)) {
    mkdir($cacheDir, 0755, true);
}

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

$data = json_decode($response, true);
if (!is_array($data)) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to parse API response']);
    exit;
}

$officialArtwork = array_map(
    fn($sprites) => $sprites['other']['official-artwork']['front_default'] ?? null,
    [$data['sprites'] ?? []]
)[0];

$officialArtwork = array_map(
    fn($sprites) => $sprites['other']['official-artwork'] ?? [],
    [$data['sprites'] ?? []]
)[0];

$filtered = [
    'id' => $data['id'] ?? null,
    'name' => $data['name'] ?? null,
    'types' => $data['types'] ?? [],
    'past_types' => $data['past_types'] ?? [],
    'sprites' => [
        'other' => [
            'official-artwork' => $officialArtwork
        ]
    ],
];

file_put_contents($cacheFile, json_encode($filtered));
echo json_encode($filtered);