<?php 

$mysqli = new mysqli("localhost","root","","ajax");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
insertdata($_POST,$mysqli);

$test['success']='inserted';


echo json_encode($test);
}else{


    $output='';


    $sql = "SELECT * FROM cart";
    $result = $mysqli->query($sql);
    
    if ($result->num_rows > 0) {
        $output.= "<table><tr><th>ID</th><th>Name</th></tr>";
      // output data of each row
    $total=0;  while($row = $result->fetch_assoc()) {
        $output.= "<tr><td>".$row["p_name"]."</td><td>".$row["price"]."::::".$row["quantity"]."</td> <td>".($row["price"]*$row["quantity"] )."</td>   </tr>";
        $total +=$row["price"]*$row["quantity"];
    }
      $output.= "<tr><td>".$total."</td><tr></table>";
    } else {
        $output.= "0 results";
    }

echo $output;

}

function insertdata($post,$mysqli){

    $sql = "SELECT count(*) as total FROM cart where pid = '".$post['pid']."' ";
    $result = $mysqli->query($sql);
    $count=$result->fetch_array();

    if ($count['total'] == 0) {
        $sql = "INSERT INTO cart (pid,p_name,price,quantity) VALUES ('".$post['pid']."', '".$post['name']."','".$post['price']."', '".$post['qty']."' )";
        if ($mysqli->query($sql) === TRUE) {
     //   echo "New record created successfully";
        } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
        }

} else {
    
    $sql = "UPDATE cart SET quantity= '".$post['qty']."' where pid = '".$post['pid']."' ";
    if ($mysqli->query($sql) === TRUE) {
 //   echo "New record created successfully";
    } else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
    }

}


}


?>