<?php
require_once '_db.php';

$insert = "INSERT INTO bookings (name, start, end, resource, guests, comments) VALUES (:name, :start, :end, :resource, :guests, :comments)";

$stmt = $db->prepare($insert);

$stmt->bindParam(':start', $start);
$stmt->bindParam(':end', $end);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':resource', $resource);
$stmt->bindParam(':guests', $guests);
$stmt->bindParam(':comments', $comments);

$received = json_decode(file_get_contents('php://input'));

$start = $received->start;
$end = $received->end;
$resource = $received->resource;
$name = $received->text;
$guests = $received->guests;
$comments = $received->comments;
$stmt->execute();

class Result {}

$response = new Result();
$response->result = 'OK';
$response->message = ' '.$db->lastInsertId();
$response->id = $db->lastInsertId();

echo json_encode($response);

?>
