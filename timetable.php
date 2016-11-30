<?php
session_start();
include "config.php";
$stmt = $db->prepare("SELECT name FROM city");
$stmt->execute();
$cities = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

include "timetable_Querries.php";

print_r(count($rows));
 ?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins)-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.16.0/moment.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.0/js/bootstrap-datetimepicker.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.0/css/bootstrap-datetimepicker.css" />

<link rel="stylesheet" type="text/css" href="./css/table-hover.css">
  <script>
  $( function() {
    $( "#datetimepicker" ).datetimepicker(
      {
      format: 'YYYY-MM-DD HH:mm:ss',
      value: new Date()
    });
  } );
  </script>
  <script type="text/javascript">
    jQuery(document).ready(function($){
        var url = window.location.href;
        $('.ul li[href="'+url+'"]').parent().addClass('active');
    });
</script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-static-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">
        <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
        <li><a href="timetable.php?trips=closest_trips">Timetable</a></li>
        <?php
        if (isset($_SESSION['type']))
        {
            if ($_SESSION['type'] == "Administrator") {
              echo '<li><a href="manageusers.php">User List(adminui)</a></li>';
            }
            if ($_SESSION['type'] == "Manager") {
              echo '<li><a href="manageTimetables.php">Manage Timetables & routes(managerONLY)</a></li>';
            }
        }
        ?>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <?php
        if (!isset($_SESSION['id']))
        { ?>
            <li><a href="signup.php">Sign up</a></li>
            <li><a href="login.php">Login</a></li>
        <?php
        }
        else
        { ?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">User<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">User Name Here</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="logout.php">Logout</a></li>
              </ul>
            </li>
        <?php
        } ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>



<form id="searchTripForm" method="post" class="form-inline">
    <div class="container">

      <div class="form-group">
        <label class="col-xs-3 control-label">City from</label>
        <div class="col-xs-5 selectContainer">
            <select class="form-control" name="city_from">
              <option value="">Choose a city</option>
                <?php
                foreach ($cities as $key => $value) {
                  echo '<option value="'.$value.'">'.$value.'</option>';                }

                 ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-3 control-label">City to</label>
        <div class="col-xs-5 selectContainer">
            <select class="form-control" name="city_to">
              <option value="">Choose a city</option>
                <?php
                foreach ($cities as $key => $value)
                {
                  echo '<option value="'.$value.'">'.$value.'</option>';
                }

                 ?>
            </select>
        </div>
    </div>

<div class="form-group">
        <div class='col-lg-12 col-md-9 col-sm-6 '>

                <div class='input-group date' id='datetimepicker'>
                    <input type='text' class="form-control" name="datetime"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>

    <div class="form-group">
        <div class="col-xs-5 col-xs-offset-3">
            <button type="submit" class="btn btn-default">Add new shirt</button>
        </div>
    </div>

</form>

      <div class="row">
        <div class="col-md-3">

          <div class="list-group">
            <a href="#" class="list-group-item active">
              Trips
            </a>
            <a href="timetable.php?trips=sold_out" class="list-group-item">Sold out Trips</a>
            <a href="timetable.php?trips=few_tickets" class="list-group-item">Few Tickets left</a>
            <a href="timetable.php?trips=closest_trips" class="list-group-item">The closest trips</a>
          </div>

        </div>
        <div class="col-md-9">
          <div class="jumbotron">

            <?php
            if ($rows != null)
            {
              ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Departure</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Price</th>
                            <th>Tickets left</th>
                            <?php
                              if (isset($_SESSION['id'])) {
                                echo "<th>Some Button</th>";
                              }
                            ?>

                        </tr>
                    </thead>


                    <tbody>
                        <?php
                          foreach ($rows as $value)
                          {
                            echo '<tr>
                            <td>'.$value['time'].'</td>
                            <td>'.$value['from_city'].'</td>
                            <td>'.$value['to_city'].'</td>
                            <td>'.$value['price'].'</td>
                            <td>'.$value['available_tickets'].'</td>';
                            if (isset($_SESSION['id']))
                            {
                              echo "<td>a</td>";
                            }
                            echo '</tr>';
                          }
                            ?>
                    </tbody>

                </table>
            <?php
              }
              else {
                echo"<h1>Deez Nuts </h1>";
              }
           ?>
          </div>
        </div>
      </div>
    </div>









  </body>
</html>