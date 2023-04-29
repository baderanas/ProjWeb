<?php

session_start();

/* Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["user"])) {
    header("location: index.html");
    exit;
}*/

//make connection
include_once ('connect.php');

// Define variables and initialize with empty values
$first_name = $last_name = $email = $sexe  = $password = $confirm_password = "";
$first_name_err = $last_name_err = $email_err = $sexe_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate first name
    if (empty(trim($_POST["fname"]))) {
        $first_name_err = "Please enter your first name.";
    } else {
        $first_name = trim($_POST["fname"]);
        echo"$first_name";
    }

    // Validate last name
    if (empty(trim($_POST["lname"]))) {
        $last_name_err = "Please enter your last name.";
    } else {
        $last_name = trim($_POST["lname"]);
        echo"$last_name";
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    }
    else {
        // Prepare a select statement
        $param_email = trim($_POST["email"]);
        $sql = "SELECT user_id FROM User WHERE email = ?";

        // Prepare the statement
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Check if the email already exists
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $email_err = "This email is already taken.";
                } else {
                    $email = trim($_POST["email"]);
                    echo"$email";
                }
            }
            else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close the statement
            mysqli_stmt_close($stmt);
        }
        else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Validate gender
    if (empty(trim($_POST["sexe"]))) {
        $sexe_err = "Please select a gender.";
    } else {
        $sexe = trim($_POST["sexe"]);
        echo"$sexe";
    }


    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 8) {
        $password_err = "Password must have at least 8 characters.";
    } else {
        $password = trim($_POST["password"]);
        echo"$password";
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);

        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
            echo"$confirm_password_err";
        }

    }

    // Check input errors before inserting in database
    if (empty($first_name_err) && empty($last_name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO User (first_name, last_name, email, sexe, password) VALUES (?,?,?,?,?)";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $first_name, $last_name, $email, $sexe, $password);
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Record inserted successfully
                echo"perfectly added";
                header("location: login.html");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close the statement
            mysqli_stmt_close($stmt);
        }


    }
}