<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$frontend = $_ENV['FRONTEND_URL'];

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: $frontend");
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once __DIR__ . '/../db/connection.php';

$method = $_SERVER['REQUEST_METHOD'];
$team_id = $_GET['team_id'] ?? null;
$user_id = $_GET['user_id'] ?? null;

function getJSON() {
    return json_decode(file_get_contents('php://input'), true);
}

switch ($method) {
    case 'GET':
        if ($team_id) {
            $stmt = $pdo->prepare("SELECT COUNT(*) AS like_count FROM team_likes WHERE team_id = ?");
            $stmt->execute([$team_id]);
            echo json_encode($stmt->fetch());
        } elseif ($user_id) {
            $stmt = $pdo->prepare(
                "SELECT teams.* FROM teams
                INNER JOIN team_likes ON teams.id = team_likes.team_id
                WHERE team_likes.user_id = ?"
            );
            $stmt->execute([$user_id]);
            echo json_encode($stmt->fetchAll());
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Missing team_id or user_id']);
        }
        break;

        case 'POST':
            break;        

    case 'DELETE':
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
}