<?php
// Wedding Group Chat WebSocket Server

$host = "0.0.0.0"; // Listen on all available network interfaces
$port = 8080;      // Port for WebSocket
$null = NULL;

// Create a socket
$server = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($server, SOL_SOCKET, SO_REUSEADDR, 1);
socket_bind($server, $host, $port);
socket_listen($server);

echo "WebSocket server started at ws://$host:$port\n";

// Array to store clients grouped by wedding ID
$wedding_clients = [];

// Function to handle initial wedding ID registration
function registerClient($client, &$wedding_clients) {
    // Read the first message (wedding ID)
    
    $wedding_id = trim(socket_read($client, 1024, PHP_BINARY_READ));
    
    // Validate wedding ID (basic check)
    if (empty($wedding_id)) {
        socket_close($client);
        echo "Invalid wedding ID. Client disconnected.\n";
        return false;
    }
    
    // Add client to the specific wedding group
    if (!isset($wedding_clients[$wedding_id])) {
        $wedding_clients[$wedding_id] = [];
    }
    $wedding_clients[$wedding_id][] = $client;
    
    echo "Client registered for Wedding ID: $wedding_id\n";
    return $wedding_id;
}

// Main server loop
while (true) {
    // Prepare an array of all connected sockets
    $read = [];
    foreach ($wedding_clients as $wedding_group) {
        $read = array_merge($read, $wedding_group);
    }
    $read[] = $server;

    // Monitor sockets for changes
    $modified_sockets = $read;
    socket_select($modified_sockets, $null, $null, 0, 10);

    // Handle new client connections
    if (in_array($server, $modified_sockets)) {
        $client = socket_accept($server);
        echo "New client attempting to connect...\n";
        
        // Register the client with a wedding ID
        $wedding_id = registerClient($client, $wedding_clients);
    }

    // Handle messages and disconnections for each wedding group
    foreach ($wedding_clients as $wedding_id => &$clients) {
        foreach ($clients as $key => $client) {
            if (in_array($client, $modified_sockets)) {
                $data = socket_read($client, 1024, PHP_BINARY_READ);

                // Handle disconnect
                if ($data === false || $data === '') {
                    echo "Client disconnected from Wedding ID: $wedding_id\n";
                    socket_close($client);
                    unset($clients[$key]);
                    continue;
                }

                // Broadcast message to all clients in the same wedding group
                foreach ($clients as $recipient) {
                    if ($recipient !== $client) {
                        socket_write($recipient, $data);
                    }
                }

                echo "Message received for Wedding ID $wedding_id: " . "\n\n";
            }
        }

        // Remove empty wedding groups
        if (empty($clients)) {
            unset($wedding_clients[$wedding_id]);
        }
    }
}
?>