<?php
$servername = 'localhost';
$username = 'urmasriis';
$password = '6OuLqn3s';
$database = 'urmasriis';




$db = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


function tableExists($dbh, $id)
{
    $results = $dbh->query("SHOW TABLES LIKE '$id'");
    if(!$results) {
        return false;
    }
    if($results->rowCount() > 0) {
        return true;
    }
    return false;
}

$exists = tableExists($db, "tables");

if (!$exists) {

    //create the database
    $db->exec("CREATE TABLE IF NOT EXISTS bookings (
        id INTEGER  PRIMARY KEY AUTO_INCREMENT NOT NULL,
        name TEXT,
        start DATETIME,
        end DATETIME,
        table_id VARCHAR(30))");

    $db->exec("CREATE TABLE IF NOT EXISTS floors (
        id INTEGER  PRIMARY KEY NOT NULL,
        name VARCHAR(200)  NULL)");

    $db->exec("CREATE TABLE IF NOT EXISTS tables (
        id INTEGER  PRIMARY KEY AUTO_INCREMENT NOT NULL,
        name VARCHAR(200)  NULL,
        floor_id INTEGER  NULL)");

  // floor data
  $items = array(
      array('id' => 1, 'name' => 'Esimene korrus'),
      array('id' => 2, 'name' => 'Teine korrus'),
      array('id' => 3, 'name' => 'Terrass')
  );

  $insert = "INSERT INTO floors (id, name) VALUES (:id, :name)";
  $stmt = $db->prepare($insert);

  $stmt->bindParam(':id', $id);
  $stmt->bindParam(':name', $name);

  foreach ($items as $item) {
    $id = $item['id'];
    $name = $item['name'];
    $stmt->execute();
  }

  // table data
  $items = array(
      array('name' => 'Laud 1', 'floor_id' => 1),
      array('name' => 'Laud 2', 'floor_id' => 1),
      array('name' => 'Laud 3', 'floor_id' => 1),
      array('name' => 'Laud 4', 'floor_id' => 1),
      
      array('name' => 'Laud 1', 'floor_id' => 2),
      array('name' => 'Laud 2', 'floor_id' => 2),
      array('name' => 'Laud 3', 'floor_id' => 2),

      array('name' => 'Laud 1', 'floor_id' => 3),
      array('name' => 'Laud 2', 'floor_id' => 3),
      array('name' => 'Laud 3', 'floor_id' => 3),
      
      
  );

  $insert = "INSERT INTO tables (name, floor_id) VALUES (:name, :floor_id)";
  $stmt = $db->prepare($insert);

  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':floor_id', $floor_id);

  foreach ($items as $item) {
    $name = $item['name'];
    $floor_id = $item['floor_id'];
    $stmt->execute();
  }
}


?>