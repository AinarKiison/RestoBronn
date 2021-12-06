


<?php
require_once '_db.php';
    
$scheduler_floors = $db->query('SELECT * FROM floors ORDER BY ID');

class Floor {}
class Resource {}

$floors = array();

foreach($scheduler_floors as $floor) {
  $g = new Floor();
  $g->id = "floor_".$floor['id'];
  $g->d_id = $floor['id'];
  $g->name = $floor['name'];
  $g->expanded = true;
  $g->children = array();
  $floors[] = $g;
  
  $stmt = $db->prepare('SELECT * FROM tables WHERE floor_id = :floor ORDER BY name');
  $stmt->bindParam(':floor', $floor['id']);
  $stmt->execute();
  $scheduler_tables = $stmt->fetchAll();  
  
  foreach($scheduler_tables as $table) {
    $r = new Resource();
    $r->id = $table['id'];
    $r->name = $table['name'];
    $g->children[] = $r;
  }
}

header('Content-Type: application/json');
echo json_encode($floors);