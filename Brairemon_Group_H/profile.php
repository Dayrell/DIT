<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="profile.css">
    
</head>

<body>
<?php
$host = 'localhost';
$user = 'root';
$pass = '';

mysql_connect($host, $user, $pass);

mysql_select_db('brairemon');
?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">E-Learning</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="home.php">Home</a></li>
      <li><a href="#">Forum</a></li>
      <li><a href="contents.php">Tutorial</a></li>
      <li><a href="#">Quiz</a></li>
	  </ul>
  <ul class="nav navbar-nav navbar-right">
      <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav>



<div id="content">
<p><?php
if(isset($_SESSION['username'])){
    echo "Welcome", $_SESSION['username'];}?>
</p> 
</div>
<h1>My Profile:</h1>
<div class="username">
<h3>Username:</h3>
</div>
<div class="highscore">
<h3>Highscore:</h3>
</div>



<html>
     <body>
<?php

if(isset($_POST['submit'])){
$name = $_FILES["file"]["name"];
//$size = $_FILES['file']['size']
//$type = $_FILES['file']['type']

$tmp_name = $_FILES['file']['tmp_name'];
$error = $_FILES['file']['error'];

if (isset ($name)) {
    if (!empty($name)) {

    $location = 'uploads/';

    if  (move_uploaded_file($tmp_name, $location.$name)){
        echo 'Uploaded';    
        }

        } else {
          echo 'please choose a file';
          }
    }
}
?>

<form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="file"><br><br>
    <input type="submit" name="submit" value="Submit">
</form>

     </body>
</html>
  <div class="row">
           <?php
            //scan "uploads" folder and display them accordingly
           $folder = "uploads";
           $results = scandir('uploads');
           foreach ($results as $result) {
            if ($result === '.' or $result === '..') continue;
            
            if (is_file($folder . '/' . $result)) {
                echo '
                <div class="col-md-3">
                    <div class="thumbnail">
                        <img src="'.$folder . '/' . $result.'" alt="...">
                            <div class="caption">
                            <p><a href="remove.php?name='.$result.'" class="btn btn-danger btn-xs" role="button">Remove</a></p>
                        </div>
                    </div>
                </div>';
            }
           }
           ?>
        </div>


<?php
$value = 50;
$max = 200;
$scale = 2.0;

// Get Percentage out of 100
if ( !empty($max) ) { $percent = ($value * 100) / $max; } 
else { $percent = 0; }

// Limit to 100 percent (if more than the max is allowed)
if ( $percent > 100 ) { $percent = 100; }
?>

<div class="percentbar" style="width:<?php echo round(100 * $scale); ?>px;">
	<div style="width:<?php echo round($percent * $scale); ?>px;"></div>
</div>

<h6>Progress: <?php echo $percent; ?>%</h6>


</body>
</html>