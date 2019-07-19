<?php
        session_start();
        $servicename = 'localhost';
        $username = 'root';
        $password = '';
        $db = "yourzone";
        $conn = mysqli_connect($serviceNae, $username, $password,$db);
        echo mysqli_connect_error(); 
   
?>