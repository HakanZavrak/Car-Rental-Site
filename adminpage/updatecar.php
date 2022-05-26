<?php
session_start();
if(!$_SESSION["adminLoggedIn"]){
    header("Location:/wen/adminpage/index.php");
}
	$sname= "localhost";
	$unmae= "root";
	$password = "";
	$db_name = "carrental";
	
	$conn = mysqli_connect($sname, $unmae, $password, $db_name);
	
	if (!$conn) {
		echo "Connection failed!";
	}
$addingError=null;
$newImageName=null;   
$carBrandQuery = "SELECT * FROM brand";
$carBrandResult = mysqli_query($conn,$carBrandQuery);

$carGearQuery = "SELECT * FROM gear";
$carTypeQuery = "SELECT * FROM cartype";
$carEngineQuery = "SELECT * FROM engine";
$carColorQuery = "SELECT * FROM color";
$carLocationQuery = "SELECT * FROM `location`";
$carGearResult = mysqli_query($conn,$carGearQuery);
$carTypeResult = mysqli_query($conn,$carTypeQuery);
$carEngineResult = mysqli_query($conn,$carEngineQuery);
$carColorResult = mysqli_query($conn,$carColorQuery);
$carLocationResult = mysqli_query($conn,$carLocationQuery);


if (($_SERVER["REQUEST_METHOD"] ?? 'POST') == "POST") {
   function update(){
    global $conn,$addingError,$newImageName;

    if(empty($_POST["plate"])){
        $addingError = "Car plate can not be empty";
        return;
    }
    else{
        $plate = $_POST["plate"];
    }
    if(empty($_POST["name"])){
        $addingError = "Car name can not be empty";
        return;
    }
    else{
        $name = $_POST["name"];
    }
    if(empty($_POST["brand"])){
        $addingError = "Car brand can not be empty";
        return;
    }
    else{
        $brand = intval($_POST["brand"]);
    }
    if(empty($_POST["modified"])){
        $addingError = "Car modified can not be empty";
        return;
    }
    else{
        $modified = $_POST["modified"];
    }
    if(empty($_POST["damagestatus"])){
        $addingError = "Car damagestatus can not be empty";
        return;
    }
    else{
        $damagestatus = $_POST["damagestatus"];
    }
    if(empty($_POST["gear"])){
        $addingError = "Car gear can not be empty";
        return;
    }
    else{
        $gear = intval($_POST["gear"]);
    }
    if(empty($_POST["type"])){
        $addingError = "Car type can not be empty";
        return;
    }
    else{
        $type = intval($_POST["type"]);
    }
    if(empty($_POST["engine"])){
        $addingError = "Car engine can not be empty";
        return;
    }
    else{
        $engine = intval($_POST["engine"]);
    }
    if(empty($_POST["color"])){
        $addingError = "Car color can not be empty";
        return;
    }
    else{
        $color = intval($_POST["color"]);
    }
    if(empty($_POST["location"])){
        $addingError = "Car location can not be empty";
        return;
    }
    else{
        $location = intval($_POST["location"]);
    }
    if(empty($_POST["price"])){
        $addingError = "Car price can not be empty";
        return;
    }
    else{
        $price = intval($_POST["price"]);
    }
    if(empty($_POST["year"])){
        $addingError = "Car year can not be empty";
        return;
    }
    else{
        $year = $_POST["year"];
    }
    
    if ($_FILES['carImage']) {
        $imageName = $_FILES['carImage']['name'];
        $tmpName = $_FILES['carImage']["tmp_name"];
        $img_ex = pathinfo($imageName, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);

        $allowed_exs = array("jpg", "jpeg", "png");
        if (in_array($img_ex_lc, $allowed_exs)) {
            $newImageName = uniqid("IMG-", true) . '.' . $img_ex_lc;
            $imageUploadPath = 'C:/xampp/htdocs/wen/images/' . $newImageName;
            move_uploaded_file($tmpName, $imageUploadPath);
        } else {
            $addingError = "You cant upload files of this type";
            return;
        }
    } else {
        $addingError = "Unknown Error occured";
        return;
    }
    echo $brand,$modified,$damagestatus,$type,$gear,$engine,$name,$color,$year,$price,$location,$plate,$newImageName;
    exit;
    $id = $_GET['id'];
    $sql ="UPDATE car SET 
    bran_id=?,
    modified=?,
    damage_status=?,
    'type_id'=?,
    gear_id=?,
    engine_id=?,
    'name'=?,
    color_id=?,
    'year'=?,
    pricing=?,
    location_id=?,
    car_plate=?,
    'image'=?
     WHERE ID=?";
             $stmt = $conn->prepare($sql);
             $stmt->bind_param("issiiisisiissi",$brand,$modified,$damagestatus,$type,$gear,$engine,$name,$color,$year,$price,$location,$plate,$newImageName,$id);
             $stmt->execute();
             $stmt->close();
             $conn->close();
           
    header("Location:admincars.php");
   }

   if(isset($_POST["update"])){
       update();
   }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car rental site</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="adminstyle.css">
    
    

</head>
    <section class="vehicles2">
        <div class="box-container">
            <div class="box">
                <div class="content">
                    <h3> <i class="fas fa-car"></i> Add a new car </h3>    
                </div>
                <form action="admincars.php" method="post" enctype="multipart/form-data">
                <div class="inputBox">
                        <h3>License Plate</h3>
                        <input type="text" name="plate" placeholder="license plate">
                    </div>
                    <div class="inputBox">
                        <h3>Car Name</h3>
                        <input type="text" name="name" placeholder="Car Name">
                    </div>
                    <div class="inputBox">
                    <h3>Car Brand</h3>
                <select class="form-control" name="brand">
                                <option value="" selected> Brand</option>
                                <?php while ($row2 = mysqli_fetch_array($carBrandResult)): ?>
                                    <option value="<?php echo $row2['ID']; ?>"><?php echo $row2['bran_name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                    </div>
                    <div class="inputBox">
                        <h3>Modify Status</h3>
                        <select class="form-control" name="modified">
                            <option value="" selected>  </option>
                            <option value="YES"> YES </option>
                            <option value="NO"> NO </option>
                        </select>
                    </div>
                    <div class="inputBox">
                        <h3>Damage Status</h3>
                        <select class="form-control" name="damagestatus">
                            <option value="" selected>  </option>
                            <option value="VERY CLEAR"> VERY CLEAR </option>
                            <option value="CLEAR"> CLEAR </option>
                            <option value="DAMAGED"> DAMAGED </option>
                            <option value="HALF DAMAGED"> HALF DAMAGED </option>
                        </select>
                    </div>
                    <div class="inputBox">
                    <select class="form-control" name="gear">
                                <option value="" selected> Gear</option>
                                <?php while ($row2 = mysqli_fetch_array($carGearResult)): ?>
                                    <option value="<?php echo $row2['ID']; ?>"><?php echo $row2['gear_type']; ?></option>
                                <?php endwhile; ?>
                            </select>
                    </div>
                    <div class="inputBox">
                    <select class="form-control" name="type">
                                <option value="" selected> Type</option>
                                <?php while ($row2 = mysqli_fetch_array($carTypeResult)): ?>
                                    <option value="<?php echo $row2['ID']; ?>"><?php echo $row2['type']. " / ". $row2["speed"]; ?></option>
                                <?php endwhile; ?>
                            </select>
                    </div>
                    <div class="inputBox">
                    <select class="form-control" name="engine">
                                <option value="" selected> Engine</option>
                                <?php while ($row2 = mysqli_fetch_array($carEngineResult)): ?>
                                    <option value="<?php echo $row2['ID']; ?>"><?php echo $row2['engine_type']; ?></option>
                                <?php endwhile; ?>
                            </select>
                    </div>
                    <div class="inputBox">
                    <select class="form-control" name="color">
                                <option value="" selected> Color</option>
                                <?php while ($row2 = mysqli_fetch_array($carColorResult)): ?>
                                    <option value="<?php echo $row2['ID']; ?>"><?php echo $row2['color']." / ". $row2["metal_type"]; ?></option>
                                <?php endwhile; ?>
                            </select>
                    </div>
                    <div class="inputBox">
                    <select class="form-control" name="location">
                                <option value="" selected> Location</option>
                                <?php while ($row2 = mysqli_fetch_array($carLocationResult)): ?>
                                    <option value="<?php echo $row2['ID']; ?>"><?php echo $row2['location']; ?></option>
                                <?php endwhile; ?>
                            </select>
                    </div>
                    <div class="inputBox">
                        <h3>Car Price</h3>
                        <input type="text" name="price" placeholder="Car Price">
                    </div>
                    <div class="inputBox">
                        <h3>Car Year</h3>
                        <input type="text" name="year" placeholder="Car Year">
                    </div>
                    <div class="form-floating mb-3">
                            <div class="input-group file" id="carImage">
                                <input type="file" class="form-control" name="carImage" id="carImage">
                            </div>
                        </div>
                    <input type="submit" name="update" value="update">
                </form> 
                    
            </div>
            
        </div>

    </section>
