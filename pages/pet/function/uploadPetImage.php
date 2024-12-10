<?php
session_start();
include_once('../../includes/dbcon.php');

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['upload_pet_image'])) {
    // Validate and sanitize input parameters
    if (!empty($_POST['pet_id']) && !empty($_FILES['pet_profile_image'])) {
        $pet_id = sanitize_input($_POST['pet_id']);
        $pet_profile_image = $_FILES['pet_profile_image'];

        // Retrieve pet_owner name from the database
        $sql_select_name = "SELECT pet_name FROM tbl_pet WHERE pet_id = ?";
        $stmt_select_name = $conn->prepare($sql_select_name);
        $stmt_select_name->bind_param("i", $pet_id);
        $stmt_select_name->execute();
        $stmt_select_name->bind_result($pet_owner_name);
        $stmt_select_name->fetch();
        $stmt_select_name->close();

        // Construct filename based on pet_owner name
        $extension = strtolower(pathinfo($pet_profile_image['name'], PATHINFO_EXTENSION));
        $file_name = $pet_owner_name . "." . $extension;
        $target_dir = "../pet_profile_upload/";
        $target_file = $target_dir . $file_name;

        // Check file size
        if ($pet_profile_image["size"] > 500000) {
            $_SESSION['error'] = "Sorry, your file is too large.";
        } else {
            // Check if file already exists
            if (file_exists($target_file)) {
                unlink($target_file); // Delete existing file
            }
            
            // Upload file
            if (move_uploaded_file($pet_profile_image["tmp_name"], $target_file)) {
                // Update pet_owner image path in the database
                $sql_update_image = "UPDATE tbl_pet SET pet_profile_image = ? WHERE pet_id = ?";
                $stmt_update_image = $conn->prepare($sql_update_image);
                $stmt_update_image->bind_param("si", $file_name, $pet_id);

                if ($stmt_update_image->execute()) {
                    $_SESSION['success'] = "The file ". htmlspecialchars(basename($pet_profile_image["name"])) . " has been uploaded.";
                } else {
                    $_SESSION['error'] = "Sorry, there was an error uploading your file.";
                }
                $stmt_update_image->close();
            } else {
                $_SESSION['error'] = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $_SESSION['error'] = 'Please select a file to upload';
    }
} else {
    $_SESSION['error'] = 'Invalid request';
}

// Redirect to the pet_owner list page
header('location: ../pet_list.php');
?>
