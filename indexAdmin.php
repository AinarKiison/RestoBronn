<?php
session_start();

if (!$_SESSION['id']) {
  header('location:login.php');
}

?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=0.9" />
  <link href="css/nav.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">



  </style>

  <!-- DayPilot library -->
  <script src="js/daypilot/daypilot-all.min.js"></script>

  <!-- DayPilot theme -->


  <link type="text/css" rel="stylesheet" href="css/scheduler_8.css" />
  <link type="text/css" rel="stylesheet" href="css/main.css" />
  <script src="js/jquery-1.9.1.min.js"></script>
  <!-- <script src="../dist/main.js"></script> -->
  <!-- <script type="module" src="js/firebase.js"></script> -->


</head>

<body id="body">
  <nav>
    <div class="menu">
      <input type="checkbox" id="check">
      <div class="logotext"><a href="#">RestoBronn </a></div>
      <!-- Nupud -->
      <ul>

        <h1 class="kasutaja">Tere, <?php echo ucfirst($_SESSION['first_name']); ?> (Admin)</h1>

        <li action=""><a href="logout.php?logout=true">
            Logi Välja
          </a></li>
      </ul>
      <label for="check" class="btn bars"><i class="fas fa-bars"></i></label>
    </div>
    </div>
  </nav>
  <div class="main">
    <div id="dp"></div>
  </div>

  <div class="form-popup" id="form-popup">
  </div>
  
  <nav>
     <div class="menu">
      <ul>
        <li><button type="button" class="nupudall" onclick="floorForm()">Lisa sektsioon</button></li>
        <li><button type="button" class="nupudall" onclick="tableForm()">Lisa laud</button></li>
        <script type="module">
      </ul>
      </div>
  </nav>
    //Future plans

    /* import {
      initializeApp
    } from "https://www.gstatic.com/firebasejs/9.3.0/firebase-app.js";
    import {
      getDatabase
    } from "https://www.gstatic.com/firebasejs/9.3.0/firebase-database.js";
    var firebaseConfig = {
      apiKey: "AIzaSyD4TvvjsF3V8PNYCgtggR7JeqQZ6yd4zKA",
      authDomain: "bron-dd8b9.firebaseapp.com",
      databaseURL: "https://bron-dd8b9-default-rtdb.europe-west1.firebasedatabase.app",
      projectId: "bron-dd8b9",
      storageBucket: "bron-dd8b9.appspot.com",
      messagingSenderId: "93398284427",
      appId: "1:93398284427:web:d363cb62211dfea9b57c8e"
    };

    const app = initializeApp(firebaseConfig);
    const db = getDatabase();
 */
  </script>
  <script type="text/javascript">
    var dp = new DayPilot.Scheduler("dp", {
      eventDeleteHandling: "Update",
      //rowMoveHandling: "Update",
      rowClickHandling: "JavaScript",
      //rowCreateHandling: "Enabled",
      treePreventParentUsage:"true",

    });


    // Display window when row is selected
    dp.onRowClick = function(args) {
      valArgs = args;
      //alert("Clicked: " + args);
      console.log(args);
      console.log(args.row.data.id);
      $("#form-popup").load('form_sectionEdit.php'); // Load form with jquery
      document.getElementById("form-popup").style.display = "block";
    };

    // delete row from table and database through form button
    function deleteRow(args) {

      a = args.row.data.d_id;
      b = args.row.data.id;

      if (confirm("Kustuta?")) {
        closeForm();
        if (a) {
          DayPilot.Http.ajax({
            url: "floor_delete.php",
            data: a,
            success: function(ajax) { // success
              var response = ajax.data;
              if (response && response.result) {
                dp.message("Kustutatud.");

                dp.rows.find(args.row.data.id).remove();
              }
            },
            error: function(ajax) {
              dp.message("Kustutamine ebaõnnestus.");
            }
          });
        } else {
          DayPilot.Http.ajax({
            url: "table_delete.php",
            data: b,
            success: function(ajax) { // success
              var response = ajax.data;
              if (response && response.result) {
                dp.message("Kustutatud.");

                dp.rows.find(args.row.data.id).remove();
              }
            },
            error: function(ajax) {
              dp.message("Kustutamine ebaõnnestus.");
            }
          });
        }

      };


    }




    // behavior and appearance
    dp.theme = "scheduler_8";
    dp.cellWidth = 80;


    var currentdate = new Date();
    var todayHour = currentdate.getHours("hh");
    var hourMinutes = currentdate.getMinutes("mm");

    // view
    console.log(todayHour + " " + hourMinutes);
    dp.startDate = DayPilot.Date.today();

    dp.days = 7;
    //dp.scale = "Hour";
    dp.scale = "CellDuration";
    dp.cellDuration = 30;
    if (hourMinutes >= 30) {
      dp.businessBeginsHour = todayHour + 0.5;
    } else {
      dp.businessBeginsHour = todayHour;
    }
    dp.businessBeginsHour = 12
    dp.businessEndsHour = 21;
    dp.businessWeekends = true;
    dp.showNonBusiness = false;
    dp.allowEventOverlap = false;
    dp.timeHeaders = [{
        groupBy: "Day",
        format: "d MMMM yyyy"
      },
      {
        groupBy: "Hour",
        format: "HH:mm"
      },



    ];
    // bubble, with async loading,

    dp.bubble = new DayPilot.Bubble({
      EventClickHandling: "Bubble",
      EventHoverHandling: "Disabled",
      onLoad: function(args) {
        var ev = args.source;
        args.async = true; // notify manually using .loaded()

        // simulating slow server-side load
        setTimeout(function() {
          args.html = "<div style='font-weight:bold'>" + ev.text() + "</div><div>Start: " + ev.start().toString("MM/dd/yyyy HH:mm") + "</div><div>End: " + ev.end().toString("MM/dd/yyyy HH:mm") + "</div><div>Id: " + ev.id() + "</div>";
          args.loaded();
        }, 50);

      }
    });

    // no events at startup, we will load them later using loadEvents()
    dp.events.list = [];

    dp.treeEnabled = true;

    // close pop-up form
    function closeForm() {
      document.getElementById("form-popup").style.display = "none";

    }


    // delete booking from table and database through form button
    function deleteBooking(args) {


      if (confirm("Kustuta broneering?")) {
        closeForm();
        DayPilot.Http.ajax({
          url: "booking_delete.php",
          data: args,
          success: function(ajax) { // success
            var response = ajax.data;
            if (response && response.result) {
              dp.message("Broneering kustutatud.");
              dp.events.remove(dp.events.find(args.e.data.id));
            }
          },
          error: function(ajax) {
            dp.message("Kustutamine ebaõnnestus.");
          }
        });
      };


    }
    // Load tables from database

    function loadTables() {
      dp.rows.load("booking_tables.php");
    }
    loadTables();



    // http://api.daypilot.org/daypilot-scheduler-onbeforeeventrender/
    dp.onBeforeEventRender = function(args) {
      args.data.cssClass = "test";
      args.data.innerHTML = args.data.text + ":";
    };

    // see http://api.daypilot.org/daypilot-scheduler-onbeforecellrender/
    dp.onBeforeCellRender = function(args) {
      if (args.cell.start.getDayOfWeek() === 6) {
        args.cell.color = "#dddddd";
      }
    };

    // http://api.daypilot.org/daypilot-scheduler-onbeforetimeheaderrender/
    dp.onBeforeTimeHeaderRender = function(args) {};

    // http://api.daypilot.org/daypilot-scheduler-onbeforeresheaderrender/
    dp.onBeforeResHeaderRender = function(args) {
      if (args.resource.loaded === false) {
        args.resource.innerHTML += " (loaded dynamically)";
      }
    };

    // http://api.daypilot.org/daypilot-scheduler-oneventmoved/
    dp.onEventMoved = function(args) {
      DayPilot.Http.ajax({
        url: "booking_move.php",
        data: args,
        success: function(ajax) { // success
          var response = ajax.data;
          if (response && response.result) {
            dp.message(response.message);
          }
        },
        error: function(ajax) {
          dp.message("Salvestamine ebaõnnestus.");
        }
      });
    };



    // http://api.daypilot.org/daypilot-scheduler-oneventresized/
    dp.onEventResized = function(args) {
      DayPilot.Http.ajax({
        url: "booking_resize.php",
        data: args,
        success: function(ajax) { // success
          var response = ajax.data;
          if (response && response.result) {
            dp.message(response.message);
          }
        },
        error: function(ajax) {
          dp.message("Salvestamine ebaõnnestus.");
        }
      });
    };
    dp.onEventDelete = function(args) {
      if (!confirm("Kustuta broneering?")) {
        args.preventDefault();
      }
    };
    dp.onEventDeleted = function(args) {
      DayPilot.Http.ajax({
        url: "booking_delete.php",
        data: args,
        success: function(ajax) { // success
          var response = ajax.data;
          if (response && response.result) {
            dp.message("Broneering kustutatud.");
          }
        },
        error: function(ajax) {
          dp.message("Kustutamine ebaõnnestus.");
        }
      });
    };

    // event creating
    // http://api.daypilot.org/daypilot-scheduler-ontimerangeselected/


    var nStart = 0;
    var nEnd = 0;
    var nResource = 0;
    var args = 0;
    dp.onTimeRangeSelected = function(args) {


      console.log(args);
      dp.allowMultiRange = false;
      nStart = args.start.value;
      nEnd = args.end.value;
      nResource = args.resource;

      $("#form-popup").load('bookingNew.php'); // Load form with jquery
      document.getElementById("form-popup").style.display = "block";

    };
    $("#form-popup").submit(function(a) {
      a.preventDefault(); // avoid to execute the actual submit of the form.
      button = document.activeElement.id; //Gets the ID of the submit button

      if (button == "new") {
        Push(nStart, nEnd, nResource);
      }
      if (button == "update") {
        Update();
      }
      if (button == "addFloor") {
        addFloor();
      }
      if (button == "addTable") {
        addTable();
      }


    });

    /* function saveBooking(nStart, nEnd, nResource) {
      var name = document.getElementById('name').value;
      newBookingRef = bookingsRef.push();
      newBookingRef.set({
        ID: newBookingRef.getKey(),
        start: nStart,
        end: nEnd,
        resource: nResource,
        text: name,

        //content: text.value


      });

    }; */

    // Add new booking 
    function Push(nStart, nEnd, nResource) {
      var name = document.getElementById('name').value;
      var guests = document.getElementById('guests').value;
      var comments = document.getElementById('comments').value;
      
      var e = {
        start: nStart,
        end: nEnd,
        resource: nResource,
        text: name,
        guests: guests,
        comments: comments
      };


      DayPilot.Http.ajax({
        url: "booking_create.php",
        data: e,
        success: function(ajax) {
          var response = ajax.data;
          if (response && response.result) {
            e.id = response.id;
            dp.events.add(e);
            dp.message("Broneering lisatud.");

          }
        },
        error: function(ajax) {
          dp.message("Salvestamine ebaõnnestus.");
        }
      });
    };

    // Update bookings through form
    function Update() {
      var name = document.getElementById('name').value;
      var guests = document.getElementById('guests').value;
      var start = document.getElementById('startTime').value;
      var end = document.getElementById('endTime').value;


      console.log(start, end, nResource, name, guests);

      var a = dp.events.find(valArgs.e.data.id); // find booking to update
      //declare for local update

      a.data.start = start;
      a.data.end = end;
      a.data.resource = nResource;
      a.data.text = name;
      a.data.guests = guests;

      //declare for database input
      var e = {
        id: valArgs.e.data.id,
        start: start,
        end: end,
        resource: nResource,
        text: name,
        guests: guests
      };

      DayPilot.Http.ajax({
        url: "booking_update.php",
        data: e,
        success: function(ajax) {
          var response = ajax.data;
          if (response && response.result) {
            e.id = response.id;

            dp.events.update(a);
            dp.message("Broneering uuendatud.");

          }
        },
        error: function(ajax) {
          dp.message("Salvestamine ebaõnnestus.");
        }
      });
    };



    // http://api.daypilot.org/daypilot-scheduler-oneventclick/
    dp.onEventClick = function(args) {
      //DayPilot.Modal.alert("ID: " + args.e.id());
      //openBookingData();
      valArgs = args;
      nResource = args.e.data.resource;
      console.log(args);
      console.log(nResource);

      $("#form-popup").load('bookingData.php'); // Load form with jquery
      document.getElementById("form-popup").style.display = "block";


    };

    dp.init();

    loadEvents();

    function loadEvents() {
      dp.events.load("booking_events.php");
    }

    function floorForm() {
      $("#form-popup").load('form_sectionNew.php'); // Load form with jquery
      document.getElementById("form-popup").style.display = "block";
    }

    function tableForm() {
      $("#form-popup").load('form_tableNew.php'); // Load form with jquery
      document.getElementById("form-popup").style.display = "block";
    }


    function addFloor() {


      var id = document.getElementById('f_id').value;
      var name = document.getElementById('f_name').value;


      //declare for database input
      var e = {
        id: id,
        name: name
      };

      DayPilot.Http.ajax({
        url: "floor_create.php",
        data: e,
        success: function(ajax) {
          var response = ajax.data;
          if (response && response.result) {
            e.id = response.id;
            dp.resources.push({
              id: id,
              name: name
            });
            dp.update();
            dp.message("Korrus lisatud.");

          }
        },
        error: function(ajax) {
          dp.message("Lisamine ebaõnnestus.");
        }
      });
    };

    function addTable() {

      var floor_id = document.getElementById('selected').value;
      var name = document.getElementById('t_name').value;
      console.log(floor_id);
      //declare for database input
      var e = {
        floor_id: floor_id,
        name: name
      };

      DayPilot.Http.ajax({
        url: "table_create.php",
        data: e,
        success: function(ajax) {
          var response = ajax.data;
          if (response && response.result) {
            e.id = response.id;
            dp.resources.push(floor_id, {
              name: name,
              id: e.id
            });
            
            dp.update();
            
            dp.message("Korrus lisatud.");

          }
        },
        error: function(ajax) {
          dp.message("Lisamine ebaõnnestus.");
        }
      });
    };
  </script>

</body>

</html>