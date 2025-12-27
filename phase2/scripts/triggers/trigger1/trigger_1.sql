DELIMITER //
CREATE TRIGGER check_capacity_before_insert
BEFORE INSERT ON Booking
FOR EACH ROW
BEGIN
    DECLARE current_passengers INT;
    DECLARE max_capacity INT;
    
    -- check aircraft capacity
    SELECT A.capacity INTO max_capacity
    FROM Flight F
    JOIN Aircraft A ON F.aircraft_id_fk = A.aircraft_id
    WHERE F.flight_number = NEW.flight_number_fk;
    
    -- count current passengers
    SELECT COUNT(*) INTO current_passengers
    FROM Booking
    WHERE flight_number_fk = NEW.flight_number_fk;
    
    -- prevent insertion if full
    IF current_passengers >= max_capacity THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'ERROR: Flight is full! Cannot accept new booking.';
    END IF;
END //
DELIMITER ;