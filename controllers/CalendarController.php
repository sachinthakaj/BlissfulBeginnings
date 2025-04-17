<?php

class CalendarController
{
    private $calendarModel;

    public function __construct()
    {
        $this->calendarModel = new Calendar();
    }

    public function setUnavailableDate($parameters)
    {
        try {
            // Authenticate the vendor
            if (!Authenticate('vendor', $parameters['vendorID'])) {
                http_response_code(401);
                echo json_encode(['error' => 'Authorization failed']);
                return;
            }

            // Get JSON input
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (empty($input['date'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Date is required']);
                return;
            }

            // Validate date format (YYYY-MM-DD)
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $input['date'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid date format. Use YYYY-MM-DD']);
                return;
            }

            // Check if date is in the past
            $today = new DateTime();
            $selectedDate = new DateTime($input['date']);
            if ($selectedDate < $today) {
                http_response_code(400);
                echo json_encode(['error' => 'Cannot mark past dates as unavailable']);
                return;
            }

            $vendorID = $parameters['vendorID'];
            $date = $input['date'];

            // Set the date as unavailable
            $dateID = $this->calendarModel->setUnavailableDate($vendorID, $date);

            if (!$dateID) {
                http_response_code(409);
                echo json_encode(['error' => 'Date is already marked as unavailable']);
                return;
            }

            echo json_encode([
                "dateID" => $dateID,
                "status" => "OK",
                "message" => "Date marked as unavailable"
            ]);

        } catch (Exception $e) {
            error_log($e->getMessage());
            http_response_code(500);
            echo json_encode(["error" => "Failed to set unavailable date"]);
        }
    }

    public function getUnavailableDates($parameters)
    {
        try {
            // Authenticate the vendor
            if (!Authenticate('vendor', $parameters['vendorID'])) {
                http_response_code(401);
                echo json_encode(['error' => 'Authorization failed']);
                return;
            }

            $vendorID = $parameters['vendorID'];
            $dates = $this->calendarModel->getUnavailableDates($vendorID);

            // Format dates for response
            $formattedDates = array_map(function($date) {
                return [
                    'date' => $date->unavailable_date,
                    'formatted' => (new DateTime($date->unavailable_date))->format('M j, Y')
                ];
            }, $dates);

            echo json_encode([
                "status" => "OK",
                "dates" => $formattedDates
            ]);

        } catch (Exception $e) {
            error_log($e->getMessage());
            http_response_code(500);
            echo json_encode(["error" => "Failed to retrieve unavailable dates"]);
        }
    }

    public function removeUnavailableDate($parameters)
    {
        try {
            // Authenticate the vendor
            if (!Authenticate('vendor', $parameters['vendorID'])) {
                http_response_code(401);
                echo json_encode(['error' => 'Authorization failed']);
                return;
            }

            // Get JSON input
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (empty($input['date'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Date is required']);
                return;
            }

            $vendorID = $parameters['vendorID'];
            $date = $input['date'];

            $success = $this->calendarModel->removeUnavailableDate($vendorID, $date);

            if (!$success) {
                http_response_code(404);
                echo json_encode(['error' => 'Date not found or already available']);
                return;
            }

            echo json_encode([
                "status" => "OK",
                "message" => "Date marked as available"
            ]);

        } catch (Exception $e) {
            error_log($e->getMessage());
            http_response_code(500);
            echo json_encode(["error" => "Failed to remove unavailable date"]);
        }
    }

    public function clearAllUnavailableDates($parameters)
    {
        try {
            // Authenticate the vendor
            if (!Authenticate('vendor', $parameters['vendorID'])) {
                http_response_code(401);
                echo json_encode(['error' => 'Authorization failed']);
                return;
            }

            $vendorID = $parameters['vendorID'];
            $count = $this->calendarModel->clearAllUnavailableDates($vendorID);

            echo json_encode([
                "status" => "OK",
                "count" => $count,
                "message" => "All unavailable dates cleared"
            ]);

        } catch (Exception $e) {
            error_log($e->getMessage());
            http_response_code(500);
            echo json_encode(["error" => "Failed to clear unavailable dates"]);
        }
    }
}
?>