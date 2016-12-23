<?php
//Include database connection here
$uid = $_GET['id']; //escape the string if you like
// Run the Query
include 'conf.php'; ?>
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                          <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#general">General</a></li>
                            <li class="dropdown">
                              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Program
                              <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a data-toggle="tab" href="#undergrad">Undergraduate</a></li>
                                <li><a data-toggle="tab" href="#master">Master</a></li>
                                <li><a data-toggle="tab" href="#phd">PHD</a></li>
                              </ul>
                            </li>
                            <li><a data-toggle="tab" href="#rank">Rank</a></li>
                            <li><a data-toggle="tab" href="#adstat">Admission Statistics</a></li>
                          </ul>

                          <div class="tab-content">
                            <div id="general" class="tab-pane fade in active">
                              <table class="table table-striped">
                              <tr>
                                <?php
                                $sql = 'SELECT * FROM
                                    University
                                WHERE University.uid = '.$uid;
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                ?>
                                  <td class="info"><strong>Name</strong></td>
                                  <td class="info"><strong>Website</strong></td>
                                  <td class="info"><strong>Location</strong></td>
                                              <tr>
                                              <td><?php echo $row['full_name']; ?></td>
                                              <td>
                                                <?php
                                                if($row['website']=='NULL'){
                                                  echo"N/A</td>";
                                                }
                                                else{
                                                  echo"<a href='".$row['website']."'>".$row['website']."</a></td>";
                                                }
                                                 ?>
                                              <td><?php echo $row['location']; ?></td>
                                              </tr>
                                  </table>

                                  <table class="table table-striped">
                                  <tr>
                                      <td class="success"><strong>Number of Undergraduate</strong></td>
                                      <td class="success"><strong>Number of Graduate</strong></td>
                                      <td class="success"><strong>Sex Ratio</strong></td>
                                      <td class="success"><strong>International Student</strong></td>
                                                  <tr>
                                                    <td><?php if ($row['num_of_undergrad']) {
                                    echo $row['num_of_undergrad'];
                                } else {
                                    echo 'N/A';
                                } ?></td>
                                                    <td><?php if ($row['num_of_grad']) {
                                    echo $row['num_of_grad'];
                                } else {
                                    echo 'N/A';
                                } ?></td>
                                                  <td><?php if ($row['male_stu'] and $row['female_stu']) {
                                    echo round((float) $row['male_stu'] / $row['female_stu'] * 100).'%';
                                } else {
                                    echo 'N/A';
                                }?></td>
                                                  <td><?php if ($row['international_stu']) {
                                    echo $row['international_stu'];
                                } else {
                                    echo 'N/A';
                                } ?></td>

                                                  </tr>
                                      </table>
                                      <table class="table table-striped">
                                      <tr>
                                          <td class="warning"><strong>Living Expense</strong></td>
                                          <td class="warning"><strong>Tuition</strong></td>
                                          <td class="warning"><strong>Average Starting Salary</strong></td>
                                                      <tr>
                                                      <td><?php if ($row['living_expense']) {
                                    echo $row['living_expense'];
                                } else {
                                    echo 'N/A';
                                } ?></td>
                                                      <td><?php if ($row['tuition']) {
                                    echo $row['tuition'];
                                } else {
                                    echo 'N/A';
                                } ?></td>
                                                      <td><?php if ($row['average_starting_salary']) {
                                    echo $row['average_starting_salary'];
                                } else {
                                    echo 'N/A';
                                } ?></td>
                                                      </tr>
                                          </table>
                            </div>
                            <div id="undergrad" class="tab-pane fade pre-scrollable" >
                              <table class="table table-striped">
                                <?php
                                $sql = 'SELECT * FROM
                                    University, Program
                                WHERE University.uid=Program.uid AND University.uid = '.$uid;
                                $result = $conn->query($sql);
                                ?>

                              <tr>
                                  <td class="success"><strong>Undergraduate Program</strong></td>
                                  <?php
                                  $i = 0;
                                   while ($row = $result->fetch_assoc()) {
                                       if ($row['degree'] == 'undergrad') {
                                         $i += 1;
                                           ?>
                                       <tr>
                                       <td><?php if ($row['pname']) {
                                               echo $row['pname'];
                                           } else {
                                               echo 'N/A';
                                           } ?></td>
                                       </tr>
                           <?php
                                       } else {
                                           continue;
                                       }
                                   }
                                   if($i == 0){
                                   echo "<tr><td>N/A<td></tr>";}
                           ?>
                                  </table>
                            </div>
                            <div id="master" class="tab-pane fade pre-scrollable">
                              <table class="table table-striped">
                                <?php
                                $sql = 'SELECT * FROM
                                    University, Program
                                WHERE University.uid=Program.uid AND University.uid = '.$uid;
                                $result = $conn->query($sql);
                                ?>
                              <tr>
                                  <td class="success"><strong>Master Program</strong></td>
                                  <?php
                                  $i = 0;
                                   while ($row = $result->fetch_assoc()) {
                                       if ($row['degree'] == 'master') {
                                         $i += 1;
                                           ?>
                                       <tr>
                                       <td><?php if ($row['pname']) {
                                               echo $row['pname'];
                                           } else {
                                               echo 'N/A';
                                           } ?></td>
                                       </tr>
                              <?php

                                       } else {
                                           continue;
                                       }
                                   }
                                   if($i == 0){
                                   echo "<tr><td>N/A<td></tr>";}
                              ?>
                                  </table>
                                      </div>
                            <div id="phd" class="tab-pane fade pre-scrollable">
                              <table class="table table-striped">
                                <?php
                                $sql = 'SELECT * FROM
                                    University, Program
                                WHERE University.uid=Program.uid AND University.uid = '.$uid;
                                $result = $conn->query($sql);
                                ?>
                              <tr>
                                  <td class="success"><strong>PHD Program</strong></td>
                                  <?php
                                  $i = 0;
                                   while ($row = $result->fetch_assoc()) {
                                       if ($row['degree'] == 'phd') {
                                         $i += 1;
                                           ?>
                                       <tr>
                                       <td><?php if ($row['pname']) {
                                               echo $row['pname'];
                                           } else {
                                               echo 'N/A';
                                           } ?></td>
                                       </tr>
                              <?php

                                       } else {
                                           continue;
                                       }
                                   }
                                   if($i == 0){
                                   echo "<tr><td>N/A<td></tr>";}
                              ?>
                                  </table>
                                                      </div>
                            <div id="rank" class="tab-pane fade">
                              <table class="table table-striped">
                                <?php
                                $sql = 'SELECT * FROM
                                    University,URank
                                WHERE University.uid=URank.uid AND University.uid = '.$uid;
                                $result = $conn->query($sql);
                                ?>
                                  <td class="info"><strong>University Rank</strong></td>
                                  <td class="info"><strong>Reference</strong></td>
                                  <?php
                                   while ($row = $result->fetch_assoc()) {
                                       ?>
                                       <tr>
                                       <td><?php if ($row['rank']) {
                                           echo $row['rank'];
                                       } else {
                                           echo 'N/A';
                                       } ?></td>
                                       <td><?php if ($row['ref']) {
                                           echo $row['ref'];
                                       } else {
                                           echo 'N/A';
                                       } ?></td>
                                       </tr>
                              <?php

                                   }
                              ?>
                              </table>

                              <table class="table table-striped">
                                <?php
                                $sql = 'SELECT * FROM
                                    University,PRank
                                WHERE University.uid=PRank.uid AND University.uid = '.$uid;
                                $result = $conn->query($sql);
                                ?>
                                  <td class="info"><strong>Program Name</strong></td>
                                  <td class="info"><strong>Rank</strong></td>
                                  <td class="info"><strong>Reference</strong></td>
                                  <?php
                                   while ($row = $result->fetch_assoc()) {
                                       ?>
                                       <tr>
                                       <td><?php if ($row['subject_name']) {
                                           echo $row['subject_name'];
                                       } else {
                                           echo 'N/A';
                                       } ?></td>
                                       <td><?php if ($row['rank']) {
                                           echo $row['rank'];
                                       } else {
                                           echo 'N/A';
                                       } ?></td>
                                       <td><?php if ($row['ref']) {
                                           echo $row['ref'];
                                       } else {
                                           echo 'N/A';
                                       } ?></td>
                                       </tr>
                              <?php

                                   }
                              ?>
                              </table>


                              </div>
                            <div id="adstat" class="tab-pane fade">
                              <table class="table table-striped">
                                <?php
                                $sql = 'SELECT * FROM
                                    AdmissionStats
                                WHERE uid = '.$uid;
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                ?>
                              <tr>
                                  <td class="success"><strong>SAT math</strong></td>
                                  <td class="success"><strong>SAT writing</strong></td>
                                  <td class="success"><strong>SAT reading</strong></td>
                                  <td class="success"><strong>Number of Applications</strong></td>
                                  <td class="success"><strong>Number of Admissions</strong></td>
                                  <td class="success"><strong>Acceptance Rate</strong></td>
                                  <tr>
                                  <td><?php if ($row['SAT_math']) {
                                    echo $row['SAT_math'];
                                } else {
                                    echo 'N/A';
                                } ?></td>
                                  <td><?php if ($row['SAT_writing']) {
                                    echo $row['SAT_writing'];
                                } else {
                                    echo 'N/A';
                                } ?></td>
                                  <td><?php if ($row['SAT_reading']) {
                                    echo $row['SAT_reading'];
                                } else {
                                    echo 'N/A';
                                } ?></td>
                                  <td><?php if ($row['num_of_application']) {
                                    echo $row['num_of_application'];
                                } else {
                                    echo 'N/A';
                                } ?></td>
                                  <td><?php if ($row['num_of_admission']) {
                                    echo $row['num_of_admission'];
                                } else {
                                    echo 'N/A';
                                } ?></td>
                                  <td><?php if ($row['num_of_application'] and $row['num_of_admission']) {
                                    echo round((float) $row['num_of_admission'] / $row['num_of_application'] * 100).'%';
                                } else {
                                    echo 'N/A';
                                } ?></td>
                                  </tr>
                              </tr>
                                  </table>
                                                      </div>
                          </div>

                        </table>
                </div>
