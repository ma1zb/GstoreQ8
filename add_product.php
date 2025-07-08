<?php
header('Content-Type: application/json');

$servername = "gstoreq8.infinityfreeapp.com";
$username = "if0_39330710";
$password = "Maherxalzoubi";
$dbname = "if0_39330710_gstoreq8";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(['error' => 'فشل الاتصال بقاعدة البيانات']));
}

// استلام البيانات مع التحقق
$name = isset($_POST['name']) ? $_POST['name'] : null;
$desc = isset($_POST['description']) ? $_POST['description'] : null;
$price = isset($_POST['price']) ? floatval($_POST['price']) : null;
$qty = isset($_POST['quantity']) ? intval($_POST['quantity']) : null;
$category = isset($_POST['categoryID']) ? intval($_POST['categoryID']) : null;
$image = isset($_POST['image']) ? $_POST['image'] : null;

if (!$name || !$price || !$qty || !$category) {
    echo json_encode(['success' => false, 'error' => 'الرجاء ملء جميع الحقول الأساسية']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO Product (Name, Description, Price, Quantity, CategoryID, Image) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssdiss", $name, $desc, $price, $qty, $category, $image);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'تم إضافة المنتج بنجاح']);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
