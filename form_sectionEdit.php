<button type="button" class="sulge" onclick="closeForm()">X</button>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-container">
  <script>
    document.getElementById("header").innerHTML = valArgs.row.data.name;
    document.getElementById("f_id").value = valArgs.row.data.id;
    document.getElementById("f_name").value = valArgs.row.data.name;
  </script>
  <h2 style="text-align:center;margin-left: 25px;margin-top: 15px;margin-bottom: 15px" id="header">



  </h2>

  <label for="name"><b>Nimi</b></label>
  <input type="text" placeholder="" id="f_name" >
  <label for="name"><b>ID</b></label>
  <input type="text" placeholder="" id="f_id">
  


  <button type="submit" class="btn save" id="update" onclick="closeForm()">Salvesta muudatused</button>
  <!-- <button type="button" class="btn cancel" onclick="closeForm()">Sulge</button> -->
  <button type="button" class="btn delete" onclick="deleteRow(valArgs)">Kustuta</button>
</form>