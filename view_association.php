<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome for icons -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 500px;
            height:490px;
            font-family:cursive;
            background-color: #ff6633; 
            border-radius: 5px;
            box-shadow: 0 0 10px #152d53;
            padding: 20px;
            border-radius: 12px;
        }

        h2 {
            color: dark;
            margin-bottom: 22px;
            font-size:30px;
            text-align:center;
            margin-top:-10px;
            color: #ff6633;
            font-family:sans-serif;
        }

        p {
            
            font-size:24px;
            margin-top: 10px;
        }

        .error {
            color: #ff0000;
            font-weight: bold;
            margin-top: 10px;
        }

        .button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .link {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .link:hover {
            color: #0056b3;
        }

        .association-details {
            margin-top: -10px;
            padding: 30px;
            height:370px;
            border: 1px solid #ccc;
            border-radius: 5px;
           box-shadow:0 0 10px #152d53;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="color:white;margin-top:10px;font-size:32px;">Deliver Food to this Association</h2>
        <div class="association-details">
            <!-- PHP-generated association details will be displayed here -->
            <?php
include 'db_conn.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: loginvolunteer.php");
    exit();
}

// Retrieve the username from the session
$username = $_SESSION['username'];

// Define association types and their priorities
$association_types = [
    'orphanage' => 1,
    'infirmary' => 2,
    'handicapped' => 3,
    'charitypoor' => 4,
    'scouts' => 5,
    'lunatics' => 6
];


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['view_association'])) {
    // Get the event ID from the request
    if (!isset($_GET['event_id'])) {
        echo "Error: Event ID is missing.";
        exit();
    }
    
    $event_id = $_GET['event_id'];

    // Check if the association is already assigned to the event
    $check_association_query = "SELECT * FROM assdriver WHERE eid = '$event_id'";
    $check_association_result = mysqli_query($conn, $check_association_query);

    if (!$check_association_result) {
        echo "Error: " . mysqli_error($conn);
        exit();
    }

    if (mysqli_num_rows($check_association_result) > 0) {
        // Association is already assigned, fetch and display its details
        $association_row = mysqli_fetch_assoc($check_association_result);
        $aid = $association_row['aid'];

        // Retrieve association details from the association table
        $get_association_query = "SELECT * FROM association WHERE aid = '$aid'";
        $get_association_result = mysqli_query($conn, $get_association_query);

        if (!$get_association_result) {
            echo "Error: " . mysqli_error($conn);
            exit();
        }

        $association_details = mysqli_fetch_assoc($get_association_result);

        if (!$association_details) {
            echo "Error: Association details not found.";
            exit();
        }

        // Display association details
       
        echo "<p><strong style='color:#ff6633;'>Name:</strong> <span style='color: #152d53;font-size:30px;'>{$association_details['name']}</span></p>";
        echo "<p><strong style='color:#ff6633;'>Type:</strong><span style='color: #152d53;font-size:30px;'> {$association_details['type']}</span></p>";
        echo "<p><strong style='color:#ff6633;'>Address:</strong> <span style='color: #152d53;font-size:30px;'>{$association_details['address']}</span></p>";
        echo "<p><strong style='color:#ff6633;'>Phone:</strong> <span style='color: #152d53;font-size:30px;'>{$association_details['phone']}</span></p>";
        echo "<p><strong style='color:#ff6633;'>Ration Food:</strong> <span style='color: #152d53;font-size:30px;'>{$association_details['rationfood']}</span></p>";
        // Display other details as needed
        exit();
    }

    // Fetch the event details from the database
    $event_query = "SELECT * FROM eventt WHERE eid = '$event_id'";
    $event_result = mysqli_query($conn, $event_query);

    if (!$event_result) {
        echo "Error: " . mysqli_error($conn);
        exit();
    }

    // Fetch the event details
    $event_details = mysqli_fetch_assoc($event_result);

    if (!$event_details) {
        echo "Error: Event details not found.";
        exit();
    }

    // Retrieve the food items from the event details
    $food_items = explode(',', $event_details['fooditem']);

    if ($event_details['status'] == "one") {
        // Check if the association is already in alwaysasso
        $check_always_query = "SELECT * FROM alwaysasso WHERE aid IN (SELECT aid FROM assdriver WHERE eid = '$event_id')";
        $check_always_result = mysqli_query($conn, $check_always_query);
        
        if (!$check_always_result) {
            echo "Error: " . mysqli_error($conn);
            exit();
        }
        
        if (mysqli_num_rows($check_always_result) > 0) {
            echo "Error: Association already assigned to an event with status 'always'.";
            exit();
        }
        
        // Define the minimum gap between events (in days)
        $min_event_gap = 5;
    
        // Define the priority order of association types
        $association_priority = [
            'orphanage' => 1,
            'infirmary' => 2,
            'handicapped' => 3,
            'charitypoor' => 4,
            'scouts' => 5,
            'lunatics' => 6
        ];
    
        // Initialize variables to track the selected association
        $selected_association_id = null;
        $max_percent = -1;
        $selected_association_type = null;
    
        // Iterate through each association type in the priority order
        foreach ($association_priority as $type => $priority) {
            // Fetch associations of the current type with the same food types as the event, ordered by percent in descending order
            foreach ($food_items as $food_item) {
                $association_query = "SELECT * FROM association 
                                      WHERE type = '$type' AND foodtype = '{$food_item}' 
                                      ORDER BY percent DESC";
    
                $association_result = mysqli_query($conn, $association_query);
    
                if (!$association_result) {
                    echo "Error: " . mysqli_error($conn);
                    exit();
                }
    
                // Fetch the current date of the new event
                $new_event_date = strtotime($event_details['eventday']);
    
                // Iterate through associations of the current type to find the one with the highest percentage, sufficient gap, and not already in alwaysasso
                while ($row = mysqli_fetch_assoc($association_result)) {
                    $association_id = $row['aid'];
    
                    // Check if the association is already in alwaysasso
                    $check_always_query = "SELECT * FROM alwaysasso WHERE aid = '$association_id'";
                    $check_always_result = mysqli_query($conn, $check_always_query);
                    
                    if (!$check_always_result) {
                        echo "Error: " . mysqli_error($conn);
                        exit();
                    }
                    
                    if (mysqli_num_rows($check_always_result) > 0) {
                        continue; // Skip this association
                    }
    
                    // Fetch the last assigned event date for this association
                    $last_event_query = "SELECT MAX(eventdday) AS last_event_date FROM assdriver WHERE aid = '$association_id'";
                    $last_event_result = mysqli_query($conn, $last_event_query);
    
                    if (!$last_event_result) {
                        echo "Error: " . mysqli_error($conn);
                        exit();
                    }
    
                    $last_event_row = mysqli_fetch_assoc($last_event_result);
                    $last_event_date = strtotime($last_event_row['last_event_date']);
    
                    // Calculate the time difference in days
                    $time_diff_days = ($new_event_date - $last_event_date) / (60 * 60 * 24);
    
                    // Check if the time difference meets the minimum gap requirement and the association has a higher percentage
                    if ($time_diff_days >= $min_event_gap && $row['percent'] > $max_percent) {
                        // Update the selected association
                        $selected_association_id = $association_id;
                        $max_percent = $row['percent'];
                        $selected_association_type = $type;
                    }
                }
            }
    
            // If a suitable association is found, break the loop
            if ($selected_association_id !== null) {
                break;
            }
        }
    
        // Check if an association has been selected
        if ($selected_association_id !== null) {
            // Insert the event into the assdriver table for the selected association
            $insert_query = "INSERT INTO assdriver (aid, eid, eventdday) VALUES ('$selected_association_id', '$event_id', '{$event_details['eventday']}')";
    
            if (mysqli_query($conn, $insert_query)) {
                // Fetch and display the association details
                $selected_association_query = "SELECT * FROM association WHERE aid = '$selected_association_id'";
                $selected_association_result = mysqli_query($conn, $selected_association_query);
    
                if (!$selected_association_result) {
                    echo "Error: " . mysqli_error($conn);
                    exit();
                }
    
                $selected_association_row = mysqli_fetch_assoc($selected_association_result);

                echo "<h2>Association Details</h2>";
                echo "<p><strong style='color:#ff6633;'>Name:</strong> <span style='color: #152d53;font-size:30px;'> {$selected_association_row['name']}</span></p>";
                echo "<p><strong style='color:#ff6633;'>Type:</strong> <span style='color: #152d53;font-size:30px;'> {$selected_association_row['type']}</span></p>";
                echo "<p><strong style='color:#ff6633;'>Address:</strong> <span style='color: #152d53;font-size:30px;'> {$selected_association_row['address']}</span></p>";
                echo "<p><strong style='color:#ff6633;'>Phone:</strong> <span style='color: #152d53;font-size:30px;'>{$selected_association_row['phone']}</span></p>";
                echo "<p><strong style='color:#ff6633;'>Ration Food:</strong> <span style='color: #152d53;font-size:30px;'>{$selected_association_row['rationfood']}</span></p>";
    

                // Add more details as needed
            } else {
                echo "Error: " . mysqli_error($conn);
                exit();
            }
        } else {
            echo "Error: No association found with sufficient gap.";
            exit();
        }
    }
    
    elseif ($event_details['status'] == "always") {
        // Check if the association is already assigned to this event in alwaysasso
        $check_always_query = "SELECT * FROM alwaysasso WHERE eid = '$event_id'";
        $check_always_result = mysqli_query($conn, $check_always_query);
        
        if (!$check_always_result) {
            echo "Error: " . mysqli_error($conn);
            exit();
        }
        
        if (mysqli_num_rows($check_always_result) > 0) {
            // Association is already assigned to this event, fetch and display its details
            $always_association_row = mysqli_fetch_assoc($check_always_result);
            $aid = $always_association_row['aid'];
    
            // Retrieve association details from the association table
            $get_association_query = "SELECT * FROM association WHERE aid = '$aid'";
            $get_association_result = mysqli_query($conn, $get_association_query);
    
            if (!$get_association_result) {
                echo "Error: " . mysqli_error($conn);
                exit();
            }
    
            $association_details = mysqli_fetch_assoc($get_association_result);
    
            if (!$association_details) {
                echo "Error: Association details not found.";
                exit();
            }
    
            // Display association details
            echo "<h2>Association Details</h2>";
            echo "<p><strong style='color:#ff6633;'>Name:</strong> <span style='color: #152d53;font-size:30px;'> {$association_details['name']}</span></p>";
            echo "<p><strong style='color:#ff6633;'>Type:</strong> <span style='color: #152d53;font-size:30px;'> {$association_details['type']}</span></p>";
            echo "<p><strong style='color:#ff6633;'>Address:</strong> <span style='color: #152d53;font-size:30px;'> {$association_details['address']}</span></p>";
            echo "<p><strong style='color:#ff6633;'>Phone:</strong> <span style='color: #152d53;font-size:30px;'>{$association_details['phone']}</span></p>";
            echo "<p><strong style='color:#ff6633;'>Ration Food:</strong> <span style='color: #152d53;font-size:30px;'>{$association_details['rationfood']}</span></p>";
          
            // Display other details as needed
            exit();
        }
    
        // If association not found in alwaysasso, continue with insertion logic
        // Fetch associations with percent greater than 60 and matching food type that are not already assigned to an event
        $association_query = "SELECT * FROM association WHERE (foodtype IN ('" . implode("','", $food_items) . "')) AND percent > 60 AND aid NOT IN (SELECT aid FROM alwaysasso)";
        $association_query .= " ORDER BY FIELD(type, 'orphanage', 'infirmary', 'handicapped', 'lunatics', 'charitypoor', 'scouts')";
        $association_result = mysqli_query($conn, $association_query);
    
        if (!$association_result) {
            echo "Error: " . mysqli_error($conn);
            exit();
        }
    
        // Check if any association matches the criteria
        if (mysqli_num_rows($association_result) > 0) {
            // Fetch the first matching association
            $association_details = mysqli_fetch_assoc($association_result);
        } else {
            // If no association with percent > 60 is found, fetch association with percent <= 60 in descending order that are not already assigned to an event
            $association_query = "SELECT * FROM association WHERE foodtype IN ('" . implode("','", $food_items) . "') AND percent <= 60 AND aid NOT IN (SELECT aid FROM alwaysasso)";
            $association_query .= " ORDER BY percent DESC";
            $association_result = mysqli_query($conn, $association_query);
    
            if (!$association_result) {
                echo "Error: " . mysqli_error($conn);
                exit();
            }
    
            // Fetch the first matching association
            $association_details = mysqli_fetch_assoc($association_result);
        }
    
        if (!$association_details) {
            echo "Error: No association found.";
            exit();
        }
    
        // Insert association ID (aid), event ID (eid), and event day into alwaysasso table
        $aid = $association_details['aid'];
        $eid = $event_id; // Event ID
        // Assuming eventday is the correct column name
        $insert_always_query = "INSERT INTO alwaysasso (aid, eid) VALUES ('$aid', '$eid')";
    
        if (mysqli_query($conn, $insert_always_query)) {
            // Fetch and display the association details
            echo "<h2>Association Details</h2>";
            echo "<p><strong style='color:#ff6633;'>Name:</strong> <span style='color: #152d53;font-size:30px;'> {$association_details['name']}</span></p>";
            echo "<p><strong style='color:#ff6633;'>Type:</strong> <span style='color: #152d53;font-size:30px;'> {$association_details['type']}</span></p>";
            echo "<p><strong style='color:#ff6633;'>Address:</strong> <span style='color: #152d53;font-size:30px;'> {$association_details['address']}</span></p>";
            echo "<p><strong style='color:#ff6633;'>Phone:</strong> <span style='color: #152d53;font-size:30px;'>{$association_details['phone']}</span></p>";
            echo "<p><strong style='color:#ff6633;'>Ration Food:</strong> <span style='color: #152d53;font-size:30px;'>{$association_details['rationfood']}</span></p>";
            // Display other details as needed
        } else {
            echo "Error: " . mysqli_error($conn);
            exit();
        }
    }
        
}
?>
        </div>
    </div>
</body>
</html>






















