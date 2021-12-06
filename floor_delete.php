<?php
require_once '_db.php';

$insert = "DELETE FROM floors WHERE id = :id";

$stmt = $db->prepare($insert);


$stmt->bindParam(':id', $id);

$received = json_decode(file_get_contents('php://input'));


$id = $received;
$stmt->execute();

class Result {}

$response = new Result();
$response->result = 'OK';
$response->message = $id;

echo json_encode($response);

?>