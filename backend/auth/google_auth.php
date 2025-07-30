<?php
session_start();

$client = require 'login.php';

require_once __DIR__ . '/../db/connection.php';


if (!isset($_GET['code'])) {
  die('No code provided');
}

$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

$client->setAccessToken($token);

$oauth = new Google_Service_Oauth2($client);
$profile = $oauth->userinfo->get();

$email = $profile->getEmail();
$name = $profile->getName();
$avatar = $profile->getPicture();
$googleId = $profile->getId();
$provider = 'google';

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
  $insert = $pdo->prepare("
    INSERT INTO users (email, name, avatar, provider, provider_id)
    VALUES (:email, :name, :avatar, :provider, :provider_id)
  ");
  $insert->execute([
    'email' => $email,
    'name' => $name,
    'avatar' => $avatar,
    'provider' => $provider,
    'provider_id' => $googleId
  ]);
  $user = $pdo->query("SELECT * FROM users WHERE email = " . $pdo->quote($email))->fetch(PDO::FETCH_ASSOC);
}

$_SESSION['user'] = [
  'id' => $user['id'],
  'email' => $user['email'],
  'name' => $user['name'],
  'avatar' => $user['avatar']
];

header('Location: ' . $_ENV['FRONTEND_URL']);
exit;