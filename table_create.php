

<?php
require_once '_db.php';



$insert = "INSERT INTO tables (name, floor_id) VALUES (:name, :floor_id)";
$stmt = $db->prepare($insert);

$stmt->bindParam(':floor_id', $floor_id);
$stmt->bindParam(':name', $name);

$received = json_decode(file_get_contents('php://input'));

$floor_id = $received->floor_id;
$name = $received->name;
$stmt->execute();

class Result {}

$response = new Result();
$response->result = 'OK';
$response->message = ' '.$db->lastInsertId();
$response->id = $db->lastInsertId();

echo json_encode($response);

?>
