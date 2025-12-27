DELIMITER //
CREATE PROCEDURE ScheduleFlight(
    IN f_num VARCHAR(10), 
    IN f_dep DATETIME, 
    IN f_arr DATETIME,
    IN f_plane VARCHAR(10)
)
BEGIN
    -- quickly insert a new flight with default route
    INSERT INTO Flight (flight_number, departure_time, arrival_time, airline_code_fk, aircraft_id_fk, origin_airport_fk, dest_airport_fk)
    VALUES (f_num, f_dep, f_arr, 'THY', f_plane, 'IST', 'LHR');
    
    SELECT 'Flight created successfully' as status;
END //
DELIMITER ;