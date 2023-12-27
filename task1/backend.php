<?php

header("Content-Type: application/json");
set_time_limit(30);

function validateInput($data) {
    if (empty($data['product_id']) || !is_numeric($data['product_id'])) {
        return "Invalid product ID";
    }

    if (empty($data['user_id']) || !is_numeric($data['user_id'])) {
        return "Invalid user ID";
    }

    if (empty($data['review_text'])) {
        return "Review text cannot be empty";
    }

    return null; // Input is valid
}

function connectToDatabase() {
    $host = "localhost";
    $database = 'product_review';
    $username = 'root';
    $password = '';

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function saveReviewToDatabase($data) {
    $conn = connectToDatabase();

    $productId = $conn->real_escape_string($data['product_id']);
    $userId = $conn->real_escape_string($data['user_id']);
    $reviewText = $conn->real_escape_string($data['review_text']);

    $sql = "INSERT INTO reviews (product_id, user_id, review_text) VALUES ('$productId', '$userId', '$reviewText')";

    if ($conn->query($sql) === TRUE) {
        $response = ["status" => "success", "message" => "Review submitted successfully"];
    } else {
        $response = ["status" => "error", "message" => "Error saving review to the database"];
    }

    $conn->close();

  
    echo json_encode($response);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = json_decode(file_get_contents('php://input'), true);

    $validationResult = validateInput($postData);

    if ($validationResult === null) {
        saveReviewToDatabase($postData);
    } else {
        echo json_encode(["status" => "error", "message" => $validationResult]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>