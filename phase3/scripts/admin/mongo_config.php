<?php
// MongoDB Connection for Admin (same as user)
$mongo_host = "mongodb://localhost:27017";
$mongo_db = "support_tickets";
$mongo_collection = "tickets";

try {
    $mongoManager = new MongoDB\Driver\Manager($mongo_host);
} catch (Exception $e) {
    die("MongoDB Connection Error: " . $e->getMessage());
}

// Get all active tickets (admin sees ALL users)
function getAllActiveTickets($manager)
{
    global $mongo_db, $mongo_collection;

    $filter = ['status' => true];
    $query = new MongoDB\Driver\Query($filter);
    $cursor = $manager->executeQuery("$mongo_db.$mongo_collection", $query);

    return $cursor->toArray();
}

// Get ticket by ID
function getTicketById($manager, $ticketId)
{
    global $mongo_db, $mongo_collection;

    $filter = ['_id' => new MongoDB\BSON\ObjectId($ticketId)];
    $query = new MongoDB\Driver\Query($filter);
    $cursor = $manager->executeQuery("$mongo_db.$mongo_collection", $query);

    $result = $cursor->toArray();
    return count($result) > 0 ? $result[0] : null;
}

// Add comment as admin
function addAdminComment($manager, $ticketId, $comment)
{
    global $mongo_db, $mongo_collection;

    $bulk = new MongoDB\Driver\BulkWrite();
    $commentData = "admin: " . $comment;

    $bulk->update(
        ['_id' => new MongoDB\BSON\ObjectId($ticketId)],
        ['$push' => ['comments' => $commentData]]
    );

    $result = $manager->executeBulkWrite("$mongo_db.$mongo_collection", $bulk);
    return $result->getModifiedCount() > 0;
}

// Mark ticket as resolved
function resolveTicket($manager, $ticketId)
{
    global $mongo_db, $mongo_collection;

    $bulk = new MongoDB\Driver\BulkWrite();
    $bulk->update(
        ['_id' => new MongoDB\BSON\ObjectId($ticketId)],
        ['$set' => ['status' => false]]
    );

    $result = $manager->executeBulkWrite("$mongo_db.$mongo_collection", $bulk);
    return $result->getModifiedCount() > 0;
}
?>