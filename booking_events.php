<?php
require_once '_db.php';
    
$result = $db->query('SELECT * FROM bookings');

class Event {}
$bookings = array();

foreach($result as $row) {
  $e = new Event();
  $e->id = $row['id'];
  $e->text = $row['name'];
  $e->start = $row['start'];
  $e->end = $row['end'];
  $e->resource = $row['resource'];
  $e->guests = $row['guests'];
  $e->comments = $row['comments'];
  $bookings[] = $e;
}

echo json_encode($bookings);
