<!DOCTYPE html>
<html lang="en" style="height: 100%;">

<head>
  <meta charset="utf-8">
</head>
<body>
  <?php

    if(isset($_GET['sql']))
    {
    $sql = $_GET['sql'];
    $sql = str_replace('$^', '+', $sql);
    }

    if(isset($_GET['page'])){
      $page = $_GET['page'];
    }
    else{
      $page = 1;
    }


    $name = strtolower(preg_replace("/[^A-Za-z0-9 ]/", '', $oname));
    include 'conf.php';
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
                  }
                }
                  ?>
                  <?php
                  echo "</div>";
                }
                else{
                  echo "<h3>Sorry, it seems we don't have information for these criteria :(</h3>";
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

</body>
</html>
