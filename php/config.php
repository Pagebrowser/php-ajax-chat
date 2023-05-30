<?php
  $hostname = "localhost";
  $username = "Erik";
  $password = "";
  $dbname = "chatapp";

  // We connect to mysql db chatapp & if the connection fails it throws a Database connection error
  $conn = mysqli_connect($hostname, $username, $password, $dbname);
  if(!$conn){
    echo "Database connection error".mysqli_connect_error();
  }
