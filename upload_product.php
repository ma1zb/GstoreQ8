<?php
header('Content-Type: application/json');

// بيانات الاتصال بقاعدة البيانات
$servername = "gstoreq8.infinityfreeapp.com";      // غيّرها حسب استضافتك
$username = "if0_39330710";           // اسم المستخدم من InfinityFree
$password = "Maherxalzoubi";        // كلمة السر
$dbname = "if0_39330710_gstoreq8";    // اسم قاعدة البيانات

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(['error' => 'فشل الاتصال بقاعدة البيانات']));
}

// مسار حفظ الصور
$uploadDir = "product_images/";
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die(json_encode(["error" => "فشل الاتصال بقاعدة البيانات"]));
}

// استقبال البيانات من C#
$productID   = $_POST['productID'] ?? '';
$name        = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$price       = $_POST['price'] ?? '';
$quantity    = $_POST['quantity'] ?? '';
$categoryID  = $_POST['categoryID'] ?? '';

// استقبال ورفع الصورة
$uploadDir = "product_images/";
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$imageName = "";
if (isset($_FILES['image'])) {
    $imageTmpName = $_FILES['image']['tmp_name'];
    $imageName = basename($_FILES['image']['name']);
    $targetPath = $uploadDir . $imageName;

    if (!move_uploaded_file($imageTmpName, $targetPath)) {
        die(json_encode(["error" => "فشل في رفع الصورة"]));
    }
} else {
    die(json_encode(["error" => "لم يتم إرسال الصورة"]));
}

// إدخال البيانات في جدول المنتجات
$stmt = $conn->prepare("INSERT INTO Product (ProductID, Name, Description, Price, Quantity, CategoryID, Image) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssdiis", $productID, $name, $description, $price, $quantity, $categoryID, $imageName);

if ($stmt->execute()) {
    echo json_encode(["success" => "✅ تم إدخال المنتج بنجاح"]);
} else {
    echo json_encode(["error" => "❌ فشل في إدخال المنتج", "details" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>