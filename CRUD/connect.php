<?php

$servername="localhost";
$dbname="crud_testing";
$username="root";
$password="";

$conn= new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error){
    exit("Connection Failed");
}
else{
    //echo "Connection Successful\n";
}

?>