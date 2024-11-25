<?php

// Fetch consultation slots (both available and booked)
function getAvailableConsultationSlots($conn) {
    // Include the 'status' field to differentiate between available and booked slots
    $stmt = $conn->prepare("SELECT id, date, time, status FROM consultation_slots WHERE status IN ('available', 'booked')");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Book a consultation slot
function bookConsultationSlot($conn, $slot_id, $user_id) {
    // Check if the slot exists and is available
    $stmt = $conn->prepare("SELECT status FROM consultation_slots WHERE id = ?");
    $stmt->bind_param("i", $slot_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return "Error: Slot does not exist.";
    }

    $slot = $result->fetch_assoc();
    if ($slot['status'] !== 'available') {
        return "Error: Slot already booked.";
    }

    // Mark the slot as booked
    $stmt = $conn->prepare("UPDATE consultation_slots SET status = 'booked', user_id = ? WHERE id = ?");
    $stmt->bind_param("ii", $user_id, $slot_id);
    if ($stmt->execute()) {
        return "Consultation slot booked successfully!";
    }

    return "Error: Unable to book slot.";
}

// Cancel a consultation slot
function cancelConsultationSlot($conn, $slot_id, $user_id) {
    // Check if the slot exists and is booked by the current user
    $stmt = $conn->prepare("SELECT user_id, status FROM consultation_slots WHERE id = ?");
    $stmt->bind_param("i", $slot_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return "Error: Slot does not exist.";
    }

    $slot = $result->fetch_assoc();
    if ($slot['status'] !== 'booked' || $slot['user_id'] != $user_id) {
        return "Error: You cannot cancel this slot.";
    }

    // Mark the slot as available
    $stmt = $conn->prepare("UPDATE consultation_slots SET status = 'available', user_id = NULL WHERE id = ?");
    $stmt->bind_param("i", $slot_id);
    if ($stmt->execute()) {
        return "Consultation slot canceled successfully!";
    }

    return "Error: Unable to cancel slot.";
}

?>
