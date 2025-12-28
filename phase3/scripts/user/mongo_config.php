<?php
// mongodb connection
// mongodb php extension is needed

$mongo_host = "mongodb://localhost:27017";
$mongo_db = "support_tickets";
$mongo_collection = "tickets";

// create mongodb manager
try {
    $mongoManager = new MongoDB\Driver\Manager($mongo_host);
} catch (Exception $e) {
    die("MongoDB Connection Error: " . $e->getMessage());
}

// get all tickets
function getTickets($manager, $username = null, $onlyActive = true)
{
    global $mongo_db, $mongo_collection;

    $filter = [];
    if ($onlyActive) {
        $filter['status'] = true;
    }
    if ($username && $username !== '') {
        $filter['username'] = $username;
    }

    $query = new MongoDB\Driver\Query($filter);
    $cursor = $manager->executeQuery("$mongo_db.$mongo_collection", $query);

    return $cursor->toArray();
}

// get one ticket by id
function getTicketById($manager, $ticketId)
{
    global $mongo_db, $mongo_collection;

    $filter = ['_id' => new MongoDB\BSON\ObjectId($ticketId)];
    $query = new MongoDB\Driver\Query($filter);
    $cursor = $manager->executeQuery("$mongo_db.$mongo_collection", $query);

    $result = $cursor->toArray();
    return count($result) > 0 ? $result[0] : null;
}

// create a new ticket
function createTicket($manager, $username, $message)
{
    global $mongo_db, $mongo_collection;

    $bulk = new MongoDB\Driver\BulkWrite();
    $document = [
        'username' => $username,
        'message' => $message,
        'created_at' => date('Y-m-d H:i:s'),
        'status' => true,  // active ticket
        'comments' => []
    ];

    $bulk->insert($document);
    $result = $manager->executeBulkWrite("$mongo_db.$mongo_collection", $bulk);

    return $result->getInsertedCount() > 0;
}

// add comment to a ticket
function addComment($manager, $ticketId, $comment, $author = 'user')
{
    global $mongo_db, $mongo_collection;

    $bulk = new MongoDB\Driver\BulkWrite();

    // comment data
    $commentData = [
        'username' => $author,
        'comment' => $comment,
        'created_at' => date('Y-m-d H:i:s')
    ];

    $bulk->update(
        ['_id' => new MongoDB\BSON\ObjectId($ticketId)],
        ['$push' => ['comments' => $commentData]]
    );

    $result = $manager->executeBulkWrite("$mongo_db.$mongo_collection", $bulk);
    return $result->getModifiedCount() > 0;
}

// mark ticket as done
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