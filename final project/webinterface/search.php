<!DOCTYPE html>
<html lang="en" style="height: 100%;">

<head>
  <title>Search</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/bootstrap-slider.css">
  <script src="js/helper.js"></script>

  <style>
  .well {
    background: rgb(249, 249, 249);
    height: 100%;
    border-radius:15px;
  }
  .row.content {
    height: 100%;
  }
  .sidenav {
    background-color: rgb(238, 237, 237);
    height: 100%;
    border-radius:15px;
  }
  @media screen and (max-width: 767px) {
    .row.content {
      height: auto;
    }
  }
  .container-fluid{
    height:100%;
  }
  body {
    height: 100%;
    padding-top: 7%;
    padding-bottom: 7%;
    padding-left: 2%;
    padding-right: 2%;
  }

  .navbar{
    margin-top: 1%;
  }
  .pre-scrollable{
    max-height: 80%;
    padding-top: 5%;
    padding-bottom: 2%;
    padding-left: 2%;
    padding-right: 2%;
    border-radius:15px;
  }
  .btn-lg{
    margin-top: 5%;
    margin-bottom: 5%;
  }
  div[id="myStyle"] {
    padding-top: 1%;
    padding-bottom: 2%;
    padding-left: 2%;
    padding-right: 2%;
  }
  </style>
</head>

<body >
  <div class="container-fluid" >
    <div class="row content">
      <div class="col-sm-3 sidenav hidden-xs">
        <h2> <span class="glyphicon glyphicon-education"></span> Find University </h2>
        <ul class="nav nav-pills nav-stacked">
          <li  class="active"> <a href="search.php" class="btn btn-info btn-lg">
            <span class="glyphicon glyphicon-search"></span> Search</a></li>
            <li> <a href="browse.php" class="btn btn-info btn-lg">
              <span class="glyphicon glyphicon-list-alt"></span> Browse</a></li>
              <li> <a href="about.php" class="btn btn-info btn-lg">
                <span class="glyphicon glyphicon-book"></span> About</a></li>
              </ul>
            </div>

            <div class="col-sm-9" style="height: 100%;">
              <div class="well">
                <nav class="navbar navbar-inverse">
                  <div class="container-fluid">
                    <form class="navbar-form navbar-right" role="form" method="post" action="search.php">
                      <div class="input-group">
                        <input name="name" type="text" class="form-control" id ='uinput' placeholder=
                        <?php
                        if($_POST["name"] or isset($_GET['name']))
                        {
                          if($_POST["name"]){
                            $uinput = strtolower(preg_replace("/[^A-Za-z0-9 ]/", '',$_POST['name']));
                            echo '"'.$uinput.'"';
                          }
                          else{
                            $uinput = strtolower(preg_replace("/[^A-Za-z0-9 ]/", '',$_GET['name']));
                            echo '"'.$uinput.'"';
                          }}
                        else{
                          echo '"'.'school name'.'"';
                        }
                          ?>
                           value=
                           <?php if($uinput){echo '"'.$uinput.'"';}else{echo'""';}?>
                           >
                          <div class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                              <i class="glyphicon glyphicon-search"></i>
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </nav>
                  <div class="row" style="height:100%;">
                    <div class="col-sm-6" id = "myStyle" style="height:100%;">
                      <?php
                      if($_POST["name"] or isset($_GET['name']))
                      {
                        if($_POST["name"]){
                          $oname = $_POST['name'];
                        }
                        else{
                          $oname = $_GET['name'];
                        }
                        if(isset($_GET['page'])){
                          $page = $_GET['page'];
                        }
                        else{
                          $page = 1;
                        }
                        $name = strtolower(preg_replace("/[^A-Za-z0-9 ]/", '', $oname));
                        include 'conf.php';
                        $sql = "SELECT uid AS 'id',location_id,full_name,website,location FROM University WHERE uid IN ( SELECT DISTINCT uid FROM Uname WHERE uname LIKE '%".$name."%')";
                        $result = $conn->query($sql);
                        $num_r = $result->num_rows;
                        if($result and $num_r > 0){
                          echo "<h3>We have ".$result->num_rows." school(s) matched :)</h3>";
                          ?>
                          <div class="pre-scrollable">
                            <table class="table table-hover">
                              <tr>
                                <th class="info col-md-9" ><strong>Name</strong></th>
                                <th class="info col-md-3" ><strong>Location</strong></th>
                              </tr>
                              <?php
                              $i = 1;
                              $j = 1;
                              while ($row = $result->fetch_assoc()) {
                                if($i <= ($page - 1) * $results_per_page){
                                  $i += 1;
                                  continue;
                                }
                                if($j <= $results_per_page){
                                  $j += 1;
                                  ?>
                                  <tr>
                                    <td class="col-md-5">
                                      <a data-toggle="modal" data-target="#myModal" href="detail.php?id=<?php echo $row['id']; ?>">
                                        <?php echo $row['full_name']; ?>
                                      </a></td>
                                      <td class="col-md-2">
                                        <a data-toggle="modal" data-target="#myModal" href="city.php?id=<?php echo $row['location_id']; ?>">
                                          <?php echo $row['location']; ?>
                                        </a></td></tr>
                                        <?php
                                      }}
                                      ?>
                                      <?php
                                      echo "</div>";
                                    }
                                    else{
                                      echo "<h3>Sorry, it seems we don't have information for ".$oname." :(</h3>";
                                    }
                                  }
                                  else{
                                    echo "<dl><H3>You can</h3><dd>- enter the school name </dd><dd>- use the filters to find your favourite school</dd></dl>";
                                  }
                                  ?>
                                </table>
                                <div class="text-center">
                                  <?php
                                  $page_limit = 10;
                                  if($num_r > $$results_per_page){
                                    echo "<ul class='pagination'>";
                                    for ($i = 1; $i <= $page_limit and $i <= ceil($num_r/$results_per_page) ; ++$i) {
                                      if ($i == $page) {
                                        echo "<li class='active'>";
                                      } else {
                                        echo '<li>';
                                      }
                                      echo "<a href='search.php?name=".$oname.'&page='.$i."'";
                                      echo '>'.$i.'</a></li>';
                                    }
                                    echo '</ul>';
                                    echo "</div>";
                                  }
                                  ?>
                                </div>
                              </div>
                              <div id="myModal" class="modal fade" role="dialog">
                                <div class="modal-dialog modal-lg">
                                  <!-- Modal content-->
                                  <div class="modal-content">
                                  </div>
                                </div>
                              </div>
                              <div class="col-sm-6" style="height:100%;">
                                <div class="pre-scrollable">
                                  <div class="well">
                                    <div class="row">
                                      <div class="col-sm-8 ">
                                        <p>University Rank</p>
                                      </div>
                                      <div class="col-sm-4 ">
                                        <input id="rank-enabled" type="checkbox"/> Enabled
                                      </div>
                                      <div class="text-center">
                                        <input id="rank" type="text" class="span2" value="" data-slider-min="1" data-slider-max="200" data-slider-step="1" data-slider-value="[1,200]" data-slider-enabled="false"/>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="well">
                                    <div class="row">
                                      <div class="col-sm-8 ">
                                        <p>Tuition</p>
                                      </div>
                                      <div class="col-sm-4 ">
                                        <input id="tuition-enabled" type="checkbox"/> Enabled
                                      </div>
                                      <div class="text-center">
                                        <input id="tuition" type="text" class="span2" value="" data-slider-min="5000" data-slider-max="20000" data-slider-step="1000" data-slider-value="[5000,20000]" data-slider-enabled="false"/>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="well">
                                    <div class="row">
                                      <div class="col-sm-8 ">
                                        <p>GPA</p>
                                      </div>
                                      <div class="col-sm-4 ">
                                        <input id="gpa-enabled" type="checkbox"/> Enabled
                                      </div>
                                      <div class="text-center">
                                        <input id="gpa" type="text" class="span2" value="" data-slider-min="2" data-slider-max="4" data-slider-step="0.1" data-slider-value="[2,4]" data-slider-enabled="false"/>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="well">
                                    <div class="row">
                                      <div class="col-sm-8 ">
                                        <p>SAT</p>
                                      </div>
                                      <div class="col-sm-4 ">
                                        <input id="sat-enabled" type="checkbox"/> Enabled
                                      </div>
                                      <div class="text-center">
                                        <input id="sat" type="text" class="span2" value="" data-slider-min="1200" data-slider-max="2400" data-slider-step="50" data-slider-value="[1200,2400]" data-slider-enabled="false"/>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="well">
                                    <div class="row">
                                      <div class="col-sm-8 ">
                                        <p>Weather</p>
                                      </div>
                                      <div class="col-sm-4 ">
                                        <input id="weather-enabled" type="checkbox"/> Enabled
                                      </div>
                                    </div>
                                    <div class="text-center">
                                      <form>
                                        <label class="checkbox-inline">
                                          <input id="1" type="checkbox" checked="checked" disabled>cold
                                        </label>
                                        <label class="checkbox-inline">
                                          <input id="2" type="checkbox" checked="checked" disabled>warm
                                        </label>
                                        <label class="checkbox-inline">
                                          <input id="3" type="checkbox" checked="checked" disabled>hot
                                        </label>
                                      </form>
                                    </div>
                                  </div>
                                  <div class="well">
                                    <div class="row">
                                      <div class="col-sm-8 ">
                                        <p>City Size</p>
                                      </div>
                                      <div class="col-sm-4 ">
                                        <input id="citysize-enabled" type="checkbox"/> Enabled
                                      </div>
                                    </div>
                                    <div class="text-center">
                                      <form>
                                        <label class="checkbox-inline">
                                          <input id="4" type="checkbox" checked="checked" disabled>small
                                        </label>
                                        <label class="checkbox-inline">
                                          <input id="5" type="checkbox" checked="checked" disabled>medium
                                        </label>
                                        <label class="checkbox-inline">
                                          <input id="6" type="checkbox" checked="checked" disabled>big
                                        </label>
                                      </form>
                                    </div>
                                  </div>
                                  <div class="well">
                                    <div class="row">
                                      <div class="col-sm-8 ">
                                        <p>Rain</p>
                                      </div>
                                      <div class="col-sm-4 ">
                                        <input id="rain-enabled" type="checkbox"/> Enabled
                                      </div>
                                    </div>
                                    <div class="text-center">
                                      <form>
                                        <label class="checkbox-inline">
                                          <input id="7" type="checkbox" checked="checked" disabled>dry
                                        </label>
                                        <label class="checkbox-inline">
                                          <input id="8" type="checkbox" checked="checked" disabled>mild
                                        </label>
                                        <label class="checkbox-inline">
                                          <input id="9" type="checkbox" checked="checked" disabled>rainy
                                        </label>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
<p id="sql"></p>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
                    <script src="js/bootstrap.min.js"></script>
                    <script src="js/bootstrap-slider.js"></script>
                    <script >$(document).ready(function() {
                      $('#myModal').on('hidden.bs.modal', function() {
                        $(this).removeData('bs.modal');
                      });
                      var change = function() {
                        $("#myStyle").removeData();
                        var sql = "\
                        FROM\
                        University\
                        LEFT JOIN\
                        URank ON University.uid = URank.uid\
                        LEFT JOIN\
                        AdmissionStats ON University.uid = AdmissionStats.uid\
                        JOIN\
                        City ON location_id = city_id\
                        JOIN\
                        Weather ON city = city_id\
                        WHERE 1=1";
                        if($("#rank-enabled").is(':checked')){
                          var tmp = rank.getValue();
                          var low = tmp[0];
                          var high = tmp[1];
                          sql = sql+" AND rank <= "+high+" AND rank >= "+low;
                        }
                        if($("#tuition-enabled").is(':checked')){
                          var tmp = tuition.getValue();
                          var low = tmp[0];
                          var high = tmp[1];
                          sql = sql+" AND tuition <= "+high+" AND tuition >= "+low;
                        }
                        if($("#sat-enabled").is(':checked')){
                          var tmp = sat.getValue();
                          var low = tmp[0];
                          var high = tmp[1];
                          sql = sql+" AND SAT_math$^SAT_reading$^SAT_writing <= "+high+" AND SAT_math$^SAT_reading$^SAT_writing >= "+low;
                        }
                        if($("#gpa-enabled").is(':checked')){
                          var tmp = gpa.getValue();
                          var low = tmp[0];
                          var high = tmp[1];
                          sql = sql+" AND gpa <= "+high+" AND gpa >= "+low;
                        }
                        if($("#citysize-enabled").is(':checked')){
                          if ($("#4").is(':checked')||$("#5").is(':checked')||$("#6").is(':checked')) {
                            sql = sql+" AND ("
                          }
                          if ($("#4").is(':checked')) {
                            sql = sql+"(area<=22 OR population<=20000)";
                          }
                          if ($("#5").is(':checked')) {
                            if ($("#4").is(':checked')) {
                              sql = sql+" OR ((area>22 AND area<=400) OR (population>23000 AND population<=100000))";
                            }
                            else{
                              sql = sql+" ((area>22 AND area<=400) OR (population>23000 AND population<=100000))";
                            }
                          }
                          if ($("#6").is(':checked')) {
                            if ($("#4").is(':checked')||$("#5").is(':checked')) {
                              sql = sql+" OR (area>400 OR population>100000)";
                            }
                            else{
                              sql = sql+" (area>400 OR population>100000)";
                            }
                          }

                          if ($("#4").is(':checked')||$("#5").is(':checked')||$("#6").is(':checked')) {
                            sql = sql+")"
                          }
                        }
                        if($("#rain-enabled").is(':checked')){
                          sql = sql+" GROUP BY University.uid HAVING 1=1";
                          if ($("#7").is(':checked')||$("#8").is(':checked')||$("#9").is(':checked')) {
                            sql = sql+" AND("
                          }

                          if ($("#7").is(':checked')) {
                            sql = sql+"SUM(day_with_precipitation)<=50";
                          }
                          if ($("#8").is(':checked')) {
                            if ($("#7").is(':checked')) {
                              sql = sql+" OR (SUM(day_with_precipitation)>50 AND SUM(day_with_precipitation)<=150)";
                            }
                            else{
                              sql = sql+" (SUM(day_with_precipitation)>50 AND SUM(day_with_precipitation)<=150)";
                            }
                          }
                          if ($("#9").is(':checked')) {
                            if ($("#7").is(':checked') || $("#8").is(':checked')) {
                              sql = sql+" OR SUM(day_with_precipitation)>150";
                            }
                            else{
                              sql = sql+"SUM(day_with_precipitation)>150";
                            }
                          }
                          if ($("#7").is(':checked')||$("#8").is(':checked')||$("#9").is(':checked')) {
                            sql = sql+")"
                          }
                        }

                        if($("#weather-enabled").is(':checked')){
                          if($("#rain-enabled").is(':checked')){
                          }
                          else{
                            sql = sql+" GROUP BY University.uid HAVING 1=1";
                          }
                          if ($("#1").is(':checked')||$("#2").is(':checked')||$("#3").is(':checked')) {
                            sql = sql+" AND("
                          }

                          if ($("#1").is(':checked')) {
                            sql = sql+"(AVG(highest_temp)<=50 OR AVG(lowest_temp)<=30)";
                          }
                          if ($("#2").is(':checked')) {
                            if ($("#1").is(':checked')) {
                              sql = sql+" OR ((AVG(highest_temp)<=70 AND AVG(highest_temp)>50) OR (AVG(lowest_temp)>30 AND AVG(lowest_temp)<=50))";
                            }
                            else{
                              sql = sql+" ((AVG(highest_temp)<=70 AND AVG(highest_temp)>50) OR (AVG(lowest_temp)>30 AND AVG(lowest_temp)<=50))";
                            }
                          }
                          if ($("#3").is(':checked')) {
                            if ($("#1").is(':checked') || $("#2").is(':checked')) {
                              sql = sql+" OR (AVG(highest_temp)>70 OR AVG(lowest_temp)>50)";
                            }
                            else{
                              sql = sql+"(AVG(highest_temp)>70 OR AVG(lowest_temp)>50)";
                            }
                          }
                          if ($("#1").is(':checked')||$("#2").is(':checked')||$("#3").is(':checked')) {
                            sql = sql+")"
                          }
                        }
                        var name = $("#uinput").attr("placeholder");
                        if(name != '' && name != 'school name'){
                          sql = "SELECT uid AS 'id',location_id,full_name,website,location FROM University WHERE uid IN ( SELECT DISTINCT uid FROM Uname WHERE uname LIKE '%"+name+"%') AND uid IN( SELECT DISTINCT University.uid "+sql+")";
                        }
                        else{
                          sql="SELECT DISTINCT University.uid AS 'id',location_id,full_name,website,location "+sql
                        }
                        //$('#sql').text(sql);
                        sql=sql.replace(/ /g,'+')
                        $('#myStyle').load('refill.php?sql='+  encodeURI(sql));
                      };

                      var rank = $('#rank').slider().on('slide', change).data('slider');
                      var tuition = $('#tuition').slider().on('slide', change).data('slider');
                      var gpa = $('#gpa').slider().on('slide', change).data('slider');
                      var sat = $('#sat').slider().on('slide', change).data('slider');


                      $("#rank").slider();
                      $("#tuition").slider();
                      $("#gpa").slider();
                      $("#sat").slider();
                      $("#weather-enabled").click(function() {
                        if(this.checked) {
                          $("#1").removeAttr("disabled");
                          $("#2").removeAttr("disabled");
                          $("#3").removeAttr("disabled");
                          change();
                        }
                        else {
                          $("#1").attr("disabled",true);
                          $("#2").attr("disabled",true);
                          $("#3").attr("disabled",true);
                          change();
                        }
                      });
                      $("#citysize-enabled").click(function() {
                        if(this.checked) {
                          $("#4").removeAttr("disabled");
                          $("#5").removeAttr("disabled");
                          $("#6").removeAttr("disabled");
                          change();
                        }
                        else {
                          $("#4").attr("disabled",true);
                          $("#5").attr("disabled",true);
                          $("#6").attr("disabled",true);
                          change();
                        }
                      });
                      $("#rain-enabled").click(function() {
                        if(this.checked) {
                          $("#7").removeAttr("disabled");
                          $("#8").removeAttr("disabled");
                          $("#9").removeAttr("disabled");
                          change();
                        }
                        else {
                          $("#7").attr("disabled",true);
                          $("#8").attr("disabled",true);
                          $("#9").attr("disabled",true);
                          change();
                        }
                      });
                      $("#rank-enabled").click(function() {
                        if(this.checked) {
                          $("#rank").slider("enable");
                          change();
                        }
                        else {
                          $("#rank").slider("disable");
                          change();
                        }
                      });
                      $("#tuition-enabled").click(function() {
                        if(this.checked) {
                          $("#tuition").slider("enable");
                          change();
                        }
                        else {
                          $("#tuition").slider("disable");
                          change();
                        }
                      });
                      $("#gpa-enabled").click(function() {
                        if(this.checked) {
                          $("#gpa").slider("enable");
                          change();
                        }
                        else {
                          $("#gpa").slider("disable");
                          change();
                        }
                      });
                      $("#sat-enabled").click(function() {
                        if(this.checked) {
                          $("#sat").slider("enable");
                          change();
                        }
                        else {
                          $("#sat").slider("disable");
                          change();
                        }
                      });
                      $("#1").click(function() {
                        change();
                      });
                      $("#2").click(function() {
                        change();
                      });
                      $("#3").click(function() {
                        change();
                      });
                      $("#4").click(function() {
                        change();
                      });
                      $("#5").click(function() {
                        change();
                      });
                      $("#6").click(function() {
                        change();
                      });
                      $("#7").click(function() {
                        change();
                      });
                      $("#8").click(function() {
                        change();
                      });
                      $("#9").click(function() {
                        change();
                      });
                    });
                    </script>
                  </body>
                  </html>
