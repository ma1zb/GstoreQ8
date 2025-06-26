<?php
header('Content-Type: application/json');

// إعداد اتصال بقاعدة البيانات
$servername = "sql210.infinityfree.com";
$username = "if0_39330710";
$password = "Maherxalzoubi";
$dbname = "if0_39330710_gstoreq8";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(['error' => 'فشل الاتصال بقاعدة البيانات']));
}

$sql = "SELECT ProductID, Name, Description, Price, Quantity, CategoryID, Image FROM Product";
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

echo json_encode($products);
$conn->close();
?>
