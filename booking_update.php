<?php
require_once '_db.php';

$json = file_get_contents('php://input');
$params = json_decode($json);

$stmt = $db->prepare("UPDATE bookings SET name = :name, start = :start, end = :end, resource = :resource, guests = :guests WHERE id = :id");
$stmt->bindParam(':id', $params->id);
$stmt->bindParam(':name', $params->text);
$stmt->bindParam(':start', $params->start);
$stmt->bindParam(':end', $params->end);
$stmt->bindParam(':resource', $params->resource);
$stmt->bindParam(':guests', $params->guests);
$stmt->execute();

class Result {}

$response = new Result();
$response->result = 'OK';
$response->message = 'Update successful';

header('Content-Type: application/json');
echo json_encode($response);