<?php 

require("conn.php");

$stmt = $conn->prepare("SELECT * FROM problems");
$stmt->execute();

$sum = 0;
    
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sum++;
    }
    echo json_encode($sum);
    
}

?>