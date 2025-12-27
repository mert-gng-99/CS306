DELIMITER //
CREATE PROCEDURE GetPassengerManifest(IN flightNo VARCHAR(10))
BEGIN
    -- retrieve passenger list for a specific flight
    SELECT P.first_name, P.last_name, B.seat_number
    FROM Booking B
    JOIN Passenger P ON B.passenger_id_fk = P.passenger_id
    WHERE B.flight_number_fk = flightNo;
END //
DELIMITER ;