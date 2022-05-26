
<?php

$hostname = "localhost";
$username = "root";
$password = "";
$databaseName = "carrental";
$connect = new mysqli($hostname, $username, $password, $databaseName);
$err = null;
if ($connect->connect_error) {
    $connect->close();
    die("Connection failed: " . $connect->connect_error);
}
$id = $_GET['id'];
$sql = "SELECT `IMAGE` FROM car WHERE ID='" . $id . "'";
$result = $connect->query($sql);
$sqlnew = "SELECT COUNT(*) FROM rented_car WHERE car_id='" . $id . "'";
$result2 = $connect->query($sqlnew);
$cnt = mysqli_num_rows($result2);

if ($result->num_rows>0) {
    while($row = $result->fetch_assoc()){
        unlink('../images/uploads/'.$row['image']);
    }
}
$sql = "DELETE FROM rented_car WHERE car_id='" . $id . "'";
mysqli_query($connect, $sql);
mysqli_close($connect);
header("Location: mybookings.php");
?>