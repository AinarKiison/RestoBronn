<button type="button" class="sulge" onclick="closeForm()">X</button>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-container">
  <script>
    document.getElementById("header").innerHTML = "Broneering " + valArgs.e.data.id;
    document.getElementById("guests").value = valArgs.e.data.guests;
    document.getElementById("comments").value = valArgs.e.data.comments;
    document.getElementById('name').value = valArgs.e.data.text;
    document.getElementById('startTime').value = valArgs.e.data.start;
    document.getElementById('endTime').value = valArgs.e.data.end;
  </script>
  <h2 style="text-align:center;margin-left: 25px;margin-top: 15px;margin-bottom: 15px" id="header">



  </h2>

  <label for="name"><b>Nimi</b></label>
  <input type="text" placeholder="Kliendi nimi" id="name" name="name">
  <label for="name"><b>Inimeste arv</b></label>
  <input type="text" placeholder="Inimeste arv" id="guests">
  <label for="name"><b>Lisainfo</b></label>
  <input type="text" placeholder="" id="comments" >
  <label for="name"><b>Algusaeg</b></label>
  <input type="text" placeholder="Algusaeg" id="startTime">
  <label for="name"><b>Lõpuaeg</b></label>
  <input type="text" placeholder="Lõpuaeg" id="endTime">


  <button type="submit" class="btn save" id="update" onclick="closeForm()">Salvesta muudatused</button>
  <!-- <button type="button" class="btn cancel" onclick="closeForm()">Sulge</button> -->
  <button type="button" class="btn delete" onclick="deleteBooking(valArgs)">Kustuta</button>
</form>