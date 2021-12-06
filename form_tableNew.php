

<?php
    require_once '_db.php';
    
    $floors = $db->query('SELECT * FROM floors');
    
?>
<button type="button" class="sulge" onclick="closeForm()">X</button>
<form method="POST" action="" class="form-container">
  <h2 style="text-align:center;margin-left: 25px;margin-top: 15px;margin-bottom: 15px">Lisa laud</h2>
  <label><b>Sektsioon</b></label>
  <div class="dropdown">
  <select id="selected" class="select">
    <?php
    foreach ($floors as $floor) {
      $id = $floor['id'];
      $name = $floor['name'];
      echo '<option value="' . $id . '">' . $name . '</option>';
    }
    
    
    ?>
  </select>
  </div>
  <label ><b>Nimi</b></label>
  <input type="text" placeholder="" value="Laud " id="t_name">


  <button type="submit" class="btn" id="addTable" onclick="closeForm()">Lisa laud</button>
  <!-- <button type="button" class="btn cancel" onclick="closeForm()">Katkesta</button> -->
</form>