<?php

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

function Authenticate($role, $ID)
{
    return True;
}


function generateUUID($dbh) {
    
    $dbh->query('SELECT REPLACE(UUID(), "-", "")');
    $dbh->execute();
    $weddingID = $dbh->fetchColumn(); 
    return $weddingID;

}
