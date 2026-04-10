<?php
header('Content-Type: application/json');
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Validate required fields
    if (empty($input['customer_name']) || empty($input['customer_email']) || 
        empty($input['booking_date']) || empty($input['booking_time'])) {
        echo json_encode(['success' => false, 'message' => 'Please fill all required fields']);
        exit;
    }
    
    try {
        // Insert booking
        $stmt = $pdo->prepare("
            INSERT INTO bookings (customer_name, customer_email, customer_phone, 
                                booking_date, booking_time, number_of_people, special_requests) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $input['customer_name'],
            $input['customer_email'],
            $input['customer_phone'] ?? '',
            $input['booking_date'],
            $input['booking_time'],
            $input['number_of_people'],
            $input['special_requests'] ?? ''
        ]);
        
        $booking_id = $pdo->lastInsertId();
        
        echo json_encode([
            'success' => true, 
            'message' => 'Booking successful!',
            'booking_id' => $booking_id
        ]);
        
    } catch(PDOException $e) {
        echo json_encode([
            'success' => false, 
            'message' => 'Booking failed: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>