<!DOCTYPE html>
<html lang="en" style="height: 100%;">

<head>
  <title>Browse</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
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
  .navbar{
    margin-top: 1%;
  }
  div[id="myStyle"] {
    padding-top: 1%;
    padding-bottom: 2%;
    padding-left: 2%;
    padding-right: 2%;
  }
  </style>
</head>

<body>
  <div class="container-fluid">
    <div class="row content">
      <div class="col-sm-3 sidenav hidden-xs">
        <h2> <span class="glyphicon glyphicon-education"></span> Find University </h2>
        <ul class="nav nav-pills nav-stacked">
          <li> <a href="search.php" class="btn btn-info btn-lg">
            <span class="glyphicon glyphicon-search"></span> Search</a></li>
            <li  class="active"> <a href="browse.php" class="btn btn-info btn-lg">
              <span class="glyphicon glyphicon-list-alt"></span> Browse</a></li>
              <li> <a href="about.php" class="btn btn-info btn-lg">
                <span class="glyphicon glyphicon-book"></span> About</a></li>
              </ul><br>
            </div>

            <div class="col-sm-9" style="height:100%;">
              <div class="well">
                <nav class="navbar navbar-inverse">
                  <div class="container-fluid">
                    <div class="navbar-header">
                      <div class="header-outer">
                        <a class="navbar-brand">Sort by:
                          <?php
                          if (isset($_GET['id'])) {
                            $t = $_GET['id'];
                          } else {
                            $t = 1;
                          }
                          switch ($t) {
                            case 1:echo 'School Name A-Z'; break;
                            case 2:echo 'School Name Z-A'; break;
                            case 3:echo 'Acceptance Rate Low-High'; break;
                            case 4:echo 'Acceptance Rate High-Low'; break;
                            case 5:echo 'Expense Low-High'; break;
                            case 6:echo 'Expense Rate High-Low'; break;
                            case 7:echo 'University Rank'; break; }
                            ?>
                          </a>
                        </div>
                      </div>
                      <div class="text-center">
                        <ul class="nav navbar-nav">
                          <li class="dropdown active">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">School Name
                              <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="browse.php?id=1">A-Z</a></li>
                                <li><a href="browse.php?id=2">Z-A</a></li>
                              </ul>
                            </li>
                          </ul>
                          <ul class="nav navbar-nav">
                            <li class="dropdown active">
                              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Acceptance Rate
                                <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                  <li><a href="browse.php?id=3">Low-High</a></li>
                                  <li><a href="browse.php?id=4">High-Low</a></li>
                                </ul>
                              </li>
                            </ul>
                            <ul class="nav navbar-nav">
                              <li class="dropdown active">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tuition + Living Expense
                                  <span class="caret"></span></a>
                                  <ul class="dropdown-menu">
                                    <li><a href="browse.php?id=5">Low-High</a></li>
                                    <li><a href="browse.php?id=6">High-Low</a></li>
                                  </ul>
                                </li>
                              </ul>
                              <ul class="nav navbar-nav">
                                <li class="active"><a href="browse.php?id=7">Rank</a></li>
                              </ul>
                            </div>
                          </div>
                        </nav>
                        <?php
                        include 'conf.php';
                        if (isset($_GET['page'])) {
                          $page = $_GET['page'];
                        } else {
                          $page = 1;
                        }
                        $start_from = ($page - 1) * $results_per_page;
                        switch ($t) {
                          case 1:
                          $sql = "SELECT
                          University.uid AS 'id',
                          website,
                          location,
                          location_id,
                          full_name,
                          num_of_undergrad + num_of_grad AS 'rate',
                          @curRank:=@curRank + 1 AS 'rank'
                          FROM
                          University,
                          (SELECT @curRank:=0) R
                          ORDER BY full_name
                          LIMIT ".$start_from.', '.$results_per_page;
                          break;
                          case 2:
                          $sql = "SELECT
                          University.uid AS 'id',
                          website,
                          location,
                          location_id,
                          full_name,
                          num_of_undergrad + num_of_grad AS 'rate',
                          @curRank:=@curRank + 1 AS 'rank'
                          FROM
                          University,
                          (SELECT @curRank:=0) R
                          ORDER BY full_name DESC
                          LIMIT ".$start_from.', '.$results_per_page;
                          break;
                          case 3:
                          $sql = "SELECT
                          University.uid AS 'id',
                          website,
                          full_name,
                          location,
                          location_id,
                          num_of_admission / num_of_application AS 'rate',
                          @curRank:=@curRank + 1 AS 'rank'
                          FROM
                          University,
                          AdmissionStats,
                          (SELECT @curRank:=0) R
                          WHERE
                          University.uid = AdmissionStats.uid
                          AND num_of_admission / num_of_application IS NOT NULL
                          ORDER BY num_of_admission / num_of_application
                          LIMIT ".$start_from.', '.$results_per_page;
                          break;
                          case 4:
                          $sql = "SELECT
                          University.uid AS 'id',
                          website,
                          full_name,
                          location,
                          location_id,
                          num_of_admission / num_of_application AS 'rate',
                          @curRank:=@curRank + 1 AS 'rank'
                          FROM
                          University,
                          AdmissionStats,
                          (SELECT @curRank:=0) R
                          WHERE
                          University.uid = AdmissionStats.uid
                          AND num_of_admission / num_of_application IS NOT NULL
                          ORDER BY num_of_admission / num_of_application DESC
                          LIMIT ".$start_from.', '.$results_per_page;
                          break;
                          case 5:
                          $sql = "SELECT
                          University.uid AS 'id',
                          website,
                          full_name,
                          location,
                          location_id,
                          tuition + living_expense AS 'rate',
                          @curRank:=@curRank + 1 AS 'rank'
                          FROM
                          University,
                          (SELECT @curRank:=0) R
                          WHERE
                          tuition IS NOT NULL AND living_expense IS NOT NULL
                          ORDER BY tuition + living_expense
                          LIMIT ".$start_from.', '.$results_per_page;
                          break;
                          case 6:
                          $sql = "SELECT
                          University.uid AS 'id',
                          website,
                          full_name,
                          location,
                          location_id,
                          tuition + living_expense AS 'rate',
                          @curRank:=@curRank + 1 AS 'rank'
                          FROM
                          University,
                          (SELECT @curRank:=0) R
                          WHERE
                          tuition IS NOT NULL AND living_expense IS NOT NULL
                          ORDER BY tuition + living_expense DESC
                          LIMIT ".$start_from.', '.$results_per_page;
                          break;
                          case 7:
                          $sql = "SELECT
                          University.uid AS 'id',
                          website,
                          full_name,
                          location,
                          location_id,
                          ref AS 'rate',
                          rank
                          FROM
                          University,
                          URank
                          WHERE
                          University.uid = URank.uid
                          ORDER BY rank
                          LIMIT ".$start_from.', '.$results_per_page;
                          break;
                        }
                        $result = $conn->query($sql);
                        ?>
                        <div class="pre-scrollable">
                          <table class="table table-hover">
                            <tr>
                              <th class="info col-md-5" ><strong>Name</strong></th>
                              <th class="info col-md-3" ><strong>Location</strong></th>
                              <th class="info col-md-2" ><strong>Website</strong></th>
                              <th class="info col-md-12"><strong><?php
                              switch ($t) {
                                case 1:echo 'Number of Student'; break;
                                case 2:echo 'Number of Student'; break;
                                case 3:echo 'Acceptance Rate'; break;
                                case 4:echo 'Acceptance Rate'; break;
                                case 5:echo 'Expense'; break;
                                case 6:echo 'Expense'; break;
                                case 7:echo 'Rank'; break;
                              }
                              ?></strong></th>
                              <?php
                              if ($t == 7) {
                                echo '<th class="info col-md-1" ><strong>Source</strong></th>';
                              }
                              ?>

                              <?php
                              while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                  <td class="col-md-5">
                                    <a data-toggle="modal" data-target="#myModal" href="detail.php?id=<?php echo $row['id']; ?>">
                                      <?php echo $row['full_name']; ?>
                                    </a></td>
                                    <td class="col-md-3">
                                      <a data-toggle="modal" data-target="#myModal" href="city.php?id=<?php echo $row['location_id']; ?>">
                                        <?php echo $row['location']; ?>
                                      </a></td>
                                      <td class="col-md-1">
                                        <?php
                                        if ($row['website'] == 'NULL') {
                                          echo'N/A</td>';
                                        } else {
                                          echo"<a href='".$row['website']."'>".$row['website'].'</a></td>';
                                        }
                                        if ($t == 7) {
                                          echo '
                                          <td>'.$row['rank'].'</td>
                                          <td>'.$row['rate'].'</td>';
                                        } else {
                                          echo '
                                          <td class="col-md-12">'.$row['rate'].'</td>';
                                        } ?>

                                      </tr>
                                      <?php

                                    }
                                    ?>
                                  </table>

                                  <div id="myModal" class="modal fade" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                      <!-- Modal content-->
                                      <div class="modal-content">

                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="text-center">
                                  <?php


                                  $page_limit = 10;
                                  echo "<ul class='pagination'>";
                                  for ($i = 1; $i <= $page_limit; ++$i) {
                                    if ($i == $page) {
                                      echo "<li class='active'>";
                                    } else {
                                      echo '<li>';
                                    }
                                    echo "<a href='browse.php?id=".$t.'&page='.$i."'";
                                    echo '>'.$i.'</a></li>';
                                  }
                                  echo '</ul>';
                                  ?>
                                </div>

                              </div>

                            </div>
                          </div>
                        </div>

                      </body>

                      </html>
