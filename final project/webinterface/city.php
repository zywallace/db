<?php
//Include database connection here
$id = $_GET['id']; //escape the string if you like
// Run the Query
include 'conf.php'; ?>

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                              <table class="table table-striped">
                                <tr>
                                  <?php
                                  $sql = 'SELECT * FROM
                                      City
                                  WHERE city_id = '.$id;
                                  $result = $conn->query($sql);
                                  $row = $result->fetch_assoc();
                                  ?>
                                    <td class="active"><strong>Name</strong></td>
                                    <td class="active"><strong>State</strong></td>
                                    <td class="active"><strong>Area</strong></td>
                                    <td class="active"><strong>Population</strong></td>
                                  </tr>
                                    <?php
                                    $cname = $row['cname'];
                                    $state = $row['state'];
                                    echo "<td>".$row['cname']."</td>";
                                    echo "<td>".$row['state']."</td>";
                                    echo "<td>".$row['area']."</td>";
                                    echo "<td>".$row['population']."</td>";
                                     ?>
                                </tr>
                              </table>
                              <table class="table table-striped">
                                <tr>
                                  <?php
                                  $sql = 'SELECT * FROM
                                      Weather
                                  WHERE city = '.$id;
                                  $result = $conn->query($sql);
                                  ?>
                                    <td class="active"><strong></strong></td>
                                    <td class="active"><strong>Jan.</strong></td>
                                    <td class="active"><strong>Feb.</strong></td>
                                    <td class="active"><strong>Mar.</strong></td>
                                    <td class="active"><strong>Apr.</strong></td>
                                    <td class="active"><strong>May</strong></td>
                                    <td class="active"><strong>June</strong></td>
                                    <td class="active"><strong>July</strong></td>
                                    <td class="active"><strong>Aug.</strong></td>
                                    <td class="active"><strong>Sept.</strong></td>
                                    <td class="active"><strong>Oct.</strong></td>
                                    <td class="active"><strong>Nov.</strong></td>
                                    <td class="active"><strong>Dec.</strong></td>
                                  </tr>
                                  <tr>
                                    <td>Day(s) with precipitation</td>
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                      echo "<td>".$row['day_with_precipitation']."</td>";
                                    }
                                     ?>
                                </tr>
                                <tr>
                                  <td class="info">Lowest temperature</td>
                                  <?php
                                  $result = $conn->query($sql);
                                  while ($row = $result->fetch_assoc()) {
                                    echo '<td class="info">'.$row['lowest_temp']."</td>";
                                  }
                                   ?>
                              </tr>
                              <tr>
                                <td class="danger">Highest temperature</td>
                                <?php
                                $result = $conn->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                  echo '<td class="danger">'.$row['highest_temp']."</td>";
                                }
                                 ?>
                            </tr>
                              </table>
                          </div>


              <div class="modal-footer">
            <i>
            <a href='<?php
            $u = "https://en.wikipedia.org/wiki/".$cname. ",_".$state;
            echo $u;
            ?>'
            >ref:wikipedia</a>
          </i>
      </div>
