<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "users");
if (!$conn) die("Connection failed: " . mysqli_connect_error());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // Ensure the action is valid before proceeding
    if (in_array($action, ['create', 'update', 'delete', 'read'])) {
        switch ($action) {
            case 'create':
                $name = $_POST['name'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];

                $query = "INSERT INTO nest (name, email, phone) VALUES ('$name', '$email', '$phone')";
                echo json_encode(['status' => mysqli_query($conn, $query) ? 'success' : 'error']);
                break;

            case 'update':
                $id = $_POST['id'];
                $name = $_POST['name'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
  
                $query = "UPDATE nest SET name='$name', email='$email', phone='$phone' WHERE id=$id";
                echo json_encode(['status' => mysqli_query($conn, $query) ? 'success' : 'error']);
                break;

            case 'delete':
                $id = $_POST['id'];

                $query = "DELETE FROM nest WHERE id=$id";
                echo json_encode(['status' => mysqli_query($conn, $query) ? 'success' : 'error']);
                break;

            case 'read':
                $result = mysqli_query($conn, "SELECT * FROM nest");
                echo json_encode(mysqli_fetch_all($result, MYSQLI_ASSOC));
                break;
        }
    } else {
        // Return an error if the action is invalid
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    }
    exit;
}

mysqli_close($conn);
?>
