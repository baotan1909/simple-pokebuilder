<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$frontend = $_ENV['FRONTEND_URL'];

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: $frontend");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Credentials: true');

require_once __DIR__ . '/../db/connection.php';

$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;

function getJSON() {
    return json_decode(file_get_contents('php://input'), true);
}

switch ($method) {
    case 'GET':
        $userId = $_GET['id'] ?? null;

        if ($userId) {
            // Fetch all teams by user_id
            $stmt = $pdo->prepare("SELECT * FROM teams WHERE user_id = ? ORDER BY created_at DESC");
            $stmt->execute([$userId]);
            $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if (!$teams) {
                echo json_encode(['error' => 'No teams found for this user']);
                return;
            }

            // Fetch all Pokemons belong to these teams
            $teamIds = array_column($teams, 'id');
            $placeholders = implode(',', array_fill(0, count($teamIds), '?'));
    
            $pokeStmt = $pdo->prepare("SELECT * FROM pokemons WHERE team_id IN ($placeholders)");
            $pokeStmt->execute($teamIds);
            $allPokemons = $pokeStmt->fetchAll(PDO::FETCH_ASSOC);

            $pokemonMap = [];
            foreach ($allPokemons as $pokemon) {
                $pokemonMap[$pokemon['team_id']][] = $pokemon;
            }

            foreach ($teams as &$team) {
                $team['pokemons'] = $pokemonMap[$team['id']] ?? [];
            }
    
            echo json_encode($teams);
            return;
        }
        // If no user_id is provided, fetch all teams
        $stmt = $pdo->query("SELECT  teams.*, users.name AS user_name
                            FROM teams
                            JOIN users ON teams.user_id = users.id
                            ORDER BY teams.id ASC");

        $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch all Pokemons and attach them to the corresponding team
        $pokeStmt = $pdo->query("SELECT * FROM pokemons");
        $allPokemons = $pokeStmt->fetchAll(PDO::FETCH_ASSOC);

        $pokemonMap = [];
        foreach ($allPokemons as $pokemon) {
            $pokemonMap[$pokemon['team_id']][] = $pokemon;
        }

        foreach ($teams as &$team) {
            $team['pokemons'] = $pokemonMap[$team['id']] ?? [];
        }
        echo json_encode($teams);
        break;

    case 'POST':
        $data = getJSON();
        if (!isset($data['user_id'], $data['name'], $data['pokemons']) || !is_array($data['pokemons'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing user_id, name, or pokemons']);
            break;
        }

        $stmt = $pdo->prepare("INSERT INTO teams (user_id, name) VALUES (:user_id, :name)");
        $stmt->execute([
            ':user_id' => $data['user_id'],
            ':name' => $data['name']
        ]);
        $teamId = $pdo->lastInsertId();

        $stmt = $pdo->prepare("INSERT INTO pokemons (team_id, species, dex_number) VALUES (?, ?, ?)");
        foreach ($data['pokemons'] as $pokemon) {
            if (!isset($pokemon['species'], $pokemon['dex_number'])) continue;
            $stmt->execute([$teamId, $pokemon['species'], $pokemon['dex_number']]);
        }

        echo json_encode(['success' => true, 'id' => $teamId]);
        break;
    
    case 'PUT':
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing team ID']);
            break;
        }

        $data = getJSON();
        if (!isset($data['name'], $data['pokemons']) || !is_array($data['pokemons'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing name or pokemons']);
            break;
        }

        $stmt = $pdo->prepare("UPDATE teams SET name = :name, updated_at = CURRENT_TIMESTAMP WHERE id = :id");
        $stmt->execute([
            ':name' => $data['name'],
            ':id' => $id
        ]);

        $stmt = $pdo->prepare("DELETE FROM pokemons WHERE team_id = ?");
        $stmt->execute([$id]);

        $stmt = $pdo->prepare("INSERT INTO pokemons (team_id, species, dex_number) VALUES (?, ?, ?)");
        foreach ($data['pokemons'] as $pokemon) {
            if (!isset($pokemon['species'], $pokemon['dex_number'])) continue;
            $stmt->execute([$id, $pokemon['species'], $pokemon['dex_number']]);
        }

        echo json_encode(['success' => true]);
        break;

    case 'DELETE':
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing team ID']);
            break;
        }

        $stmt = $pdo->prepare("DELETE FROM teams WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
}