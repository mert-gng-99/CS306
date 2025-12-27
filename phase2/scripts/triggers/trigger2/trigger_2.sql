DELIMITER //
CREATE TRIGGER log_booking_delete
AFTER DELETE ON Booking
FOR EACH ROW
BEGIN
    -- log the deleted booking details
    INSERT INTO Booking_Log (flight_number, seat_number, deleted_at, user_action)
    VALUES (OLD.flight_number_fk, OLD.seat_number, NOW(), 'Booking Cancelled');
END //
DELIMITER ;