<?php
function db_connect(){
    $host = "localhost";
    $user = "root";
    $dbpass = "Enjay@crm123";
    $dbname = "contactbook";
    $conn = mysqli_connect($host,$user,$dbpass,$dbname) or die ("Database connection error : " .mysqli_connect_error());
    return $conn;
}

function db_close($conn){
    mysqli_close($conn);
}

?>
