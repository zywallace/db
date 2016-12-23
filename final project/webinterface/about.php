<!DOCTYPE html>
<html lang="en" style="height: 100%;">

<head>
  <title>Guide</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.css">
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
    padding-bottom: 2%;
    padding-left: 2%;
    padding-right: 2%;
    border-radius:15px;
  }
  .btn-lg{
    margin-top: 5%;
    margin-bottom: 5%;
  }
  .nav-pills{
    margin-top: 1%;
  }
  div[id="myStyle"] {
    padding-top: 1%;
    padding-bottom: 2%;
    padding-left: 2%;
    padding-right: 2%;
  }
  .jumbotron{
    width: 70%;
    height: 100%;
    padding:5%;
    margin: auto;
    background: rgb(249, 249, 249);
  }
  .item{
    height: 100%;
  }
  </style>
</head>

<body>
  <div class="container-fluid">
    <div class="row content">
      <div class="col-sm-3 sidenav">
        <h2> <span class="glyphicon glyphicon-education"></span> Find University </h2>
        <ul class="nav nav-pills nav-stacked">
          <li> <a href="search.php" class="btn btn-info btn-lg">
            <span class="glyphicon glyphicon-search"></span> Search</a></li>
            <li> <a href="browse.php" class="btn btn-info btn-lg">
              <span class="glyphicon glyphicon-list-alt"></span> Browse</a></li>
              <li class="active"> <a href="about.php" class="btn btn-info btn-lg">
                <span class="glyphicon glyphicon-book"></span> About</a></li>
              </ul><br>
            </div>

            <div class="col-sm-9" style="height:100%;">
              <div class="well">
                <div class="container" style="height:100%;width:100%;">
                  <br>
                  <div id="myCarousel" class="carousel slide" data-ride="carousel" style="height:70%">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                      <li data-target="#myCarousel" data-slide-to="1"></li>
                      <li data-target="#myCarousel" data-slide-to="2"></li>
                      <li data-target="#myCarousel" data-slide-to="3"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox"style="height:100%;">

                      <div class="item active">
                        <div class="jumbotron">
                          <h1>Search</h1>
                          <p>You can easily search your favourite universities, the school name is case insensitive.</p>
                          <p>You could then use filters on the right to narrow down results or just use filters to start looking:)!</p>
                          <p>Only the first 100 universities would be displayed</p>
                        </div>
                      </div>

                      <div class="item">
                        <div class="jumbotron">
                          <h1>Browse</h1>
                          <p>You can easily browse your favourite universities, sorted by school name, rank, expense and acceptance rate.</p>
                          <p>Only the first 100 universities would be displayed</p>
                        </div>
                      </div>

                      <div class="item">
                        <div class="jumbotron">
                          <h1>Data Source</h1>
                          <p>Weather:<a href='http://www.usclimatedata.com' target="_blank">Usclimatedata</a></p>
                          <p>City and schools' nicknames:<a href='http://en.wikipedia.org' target="_blank">Wiki</a></p>
                          <p>University:<a href='http://collegedata.com' target="_blank">Colledgedata</a></p>
                          <p>University Rank:<a href='https://www.timeshighereducation.com/student/best-universities/best-universities-united-states' target="_blank">Times</a></p>
                          <p>Program Rank:<a href='http://colleges.usnews.rankingsandreviews.com/best-colleges' target="_blank">USNews</a></p>
                        </div>
                      </div>

                      <div class="item">
                        <div class="jumbotron">
                          <h1>Goal</h1>
                          <p>Knew there are numerous information online about schools</p>
                          <p>Painful to look up different sites and get nothing</p>
                          <p>Hope it help someone!</p>
                        </div>
                      </div>

                    </div>

                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>
                </div>



                </div>
              </div>
            </div>
          </div>
          </div>
        </div>
      </body>

      </html>
