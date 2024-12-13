<?php
require_once 'Config.php';

loadEnv(__DIR__ . '/../.env');

function basePath($path)
{

    return BASE_PATH . $path;
}


function abort($message, $code = 404)
{

    http_response_code($code);
    echo $message;
    exit();
}

function dataGet($arr, $key) // $key = GET./wedding/fetchData/a6018d778b9f11ef98e7cc153136262a
{
    if (!is_array($arr) || empty($key)) {
        return null;
    }

    $keysArr = explode(".", $key); //array(2) { [0]=> string(3) "GET", [1]=>string(41) "/wedding/a6018d778b9f11ef98e7cc153136262a"}
    $searchedKey = $keysArr[count($keysArr) - 1]; // string(41) "/wedding/a6018d778b9f11ef98e7cc153136262a"
    $uriSegments = explode("/", trim($searchedKey, "/")); // array(2) {[0]=>string(7) "wedding" [1]=>string(32) "a6018d778b9f11ef98e7cc153136262a"}
    $arr = $arr[$keysArr[0]];



    foreach ($arr as $routePattern => $routeData) {
        $routeSegments = explode("/", trim($routePattern, "/"));


        // If the number of segments don't match, skip this route
        if (count($routeSegments) !== count($uriSegments)) {
            continue;
        }

        // Check if the route segments match the URI segments
        $params = [];
        $isMatch = true;
        for ($i = 0; $i < count($routeSegments); $i++) {
            // If the segment is a placeholder (e.g., {id}), capture the value from the URI
            if (preg_match('/\{[^\}]+\}/', $routeSegments[$i])) {
                $paramName = trim($routeSegments[$i], "{}");
                $params[$paramName] = $uriSegments[$i];
            } elseif ($routeSegments[$i] !== $uriSegments[$i]) {
                // If a segment doesn't match and it's not a placeholder, skip this route
                $isMatch = false;
                break;
            }
        }

        // If the route matches, return the route data and the extracted parameters
        if ($isMatch) {
            $routeData['params'] = $params; // Add extracted params to the route data
            return $routeData;
        }
    }
}


function createToken($userID, $role)
{
    $issuedAt = time();
    $expirationTime = $issuedAt + 3600; // Token valid for 1 hour
    $payload = [
        'userID' => $userID, // Add user-specific data
        'role' => $role,
        'iat' => $issuedAt,
        'exp' => $expirationTime
    ];
    // Step 1: Define header and payload
    $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);

    // Step 2: Base64 encode the header and payload
    $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(json_encode($payload)));

    // Step 3: Create signature
    $signature = hash_hmac('sha256', "$base64UrlHeader.$base64UrlPayload", $_ENV['SECRET_KEY'], true);
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

    // Step 4: Concatenate to form the token
    $jwt = "$base64UrlHeader.$base64UrlPayload.$base64UrlSignature";

    return $jwt;
}

function validateToken($token) {
    // Step 1: Split the token into its parts
    $parts = explode('.', $token);
    if (count($parts) !== 3) {
        return false; // Invalid token structure
    }

    [$base64UrlHeader, $base64UrlPayload, $base64UrlSignature] = $parts;

    // Step 2: Recreate the signature
    $signature = hash_hmac('sha256', "$base64UrlHeader.$base64UrlPayload", $_ENV['SECRET_KEY'], true);
    $validSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

    if (!hash_equals($validSignature, $base64UrlSignature)) {
        return false; // Invalid signature
    }

    // Step 3: Decode the payload and check expiry
    $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $base64UrlPayload)), true);
    

    return $payload; // Valid token, return decoded payload
}

function Authenticate($role, $ID)
{
    $headers = getallheaders();
    $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : null;

    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $jwt = $matches[1];
        try {
            $decoded = validateToken($jwt);
            if ($decoded['exp'] < time()) {
                return false; // Token expired
            }
            if($decoded['role'] == $role) {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    } else {
        return false;
    }
}


function generateUUID($dbh)
{

    $dbh->query('SELECT REPLACE(UUID(), "-", "")');
    $dbh->execute();
    $weddingID = $dbh->fetchColumn();
    return $weddingID;
}
