

<?php
require_once '_db.php';



$insert = "INSERT INTO floors (id, name) VALUES (:id, :name)";
$stmt = $db->prepare($insert);

$stmt->bindParam(':id', $id);
$stmt->bindParam(':name', $name);

$received = json_decode(file_get_contents('php://input'));

$id = $received->id;
$name = $received->name;
$stmt->execute();

class Result {}

$response = new Result();
$response->result = 'OK';
$response->message = ' '.$db->lastInsertId();
$response->id = $db->lastInsertId();

echo json_encode($response);

?>
