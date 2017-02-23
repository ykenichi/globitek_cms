<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.

  $first_name = $_POST['firstname'] ?? '';
  $last_name = $_POST['lastname'] ?? '';
  $email = $_POST['email'] ?? '';
  $username = $_POST['username'] ?? '';
  $errors = array();
  
  if(is_post_request()){
    $fieldnames = array("First name ", "Last name ", "Email ", "Username ");
    $blank = " cannot be blank.";

    if(is_blank($first_name)){
      array_push($errors, $fieldnames[0] . $blank);
    }
    elseif(!has_length($first_name, array(2,255))){
      array_push($errors, $fieldnames[0] . " must be between 2 and 255 characters.");
    }
    elseif(!has_valid_characters($first_name, '/\A[A-Za-z\s\-,\.\']+\Z/')){
      array_push($errors, $fieldnames[0] . " must contain only letters, spaces, and symbols: - , . '");
    }
    
    if(is_blank($last_name)){
      array_push($errors, $fieldnames[1] . $blank);
    }
    elseif(!has_length($last_name, array(2,255))){
      array_push($errors, $fieldnames[1] . " must be between 2 and 255 characters.");
    }
    elseif(!has_valid_characters($last_name, '/\A[A-Za-z\s\-,\.\']+\Z/')){
      array_push($errors, $fieldnames[1] . " must contain only letters, spaces, and symbols: - , . '");
    }
    
    if(is_blank($email)){
      array_push($errors, $fieldnames[2] . $blank);
    }
    elseif(!has_length($email, array(0,255))){
      array_push($errors, $fieldnames[2] . " must be less than 255 characters.");
    }
    elseif(!has_valid_email_format($email)){
      array_push($errors, $fieldnames[2] . " must be a valid format.");
    }
    elseif(!has_valid_characters($email, '/\A[A-Za-z0-9_@\.]+\Z/')){
      array_push($errors, $fieldnames[2] . " must contain only letters, numbers, and symbols: _ @ .");
    }
    
    if(is_blank($username)){
      array_push($errors, $fieldnames[3] . $blank);
    }
    elseif(!has_length($username, array(8,255))){
      array_push($errors, $fieldnames[3] . " must be between 8 and 255 characters.");
    }
    elseif(!has_valid_characters($username, '/\A[A-Za-z0-9_]+\Z/')){
      array_push($errors, $fieldnames[3] . " must contain only letters, numbers, and symbols: _");
    }
    else{
      $result = db_query($db, "SELECT * FROM users WHERE username='$username'");
      if(!$result) {
        echo db_error($db);
      }
      if(db_num_rows($result) != 0) {
        array_push($errors, $fieldnames[3] . " '$username' already exists in the database.");
      }
    }
    
    if(empty($errors)){
      //echo "Form successfully submitted";
      $date = date('Y-m-d H:i:s');
      $sql = "INSERT INTO `users` (`first_name`, `last_name`, `email`, `username`, `created_at`) VALUES ('$first_name','$last_name','$email','$username','$date');";
      $result = db_query($db, $sql);
      if($result) {
        db_close($db);
        unset($db);
        redirect_to("registration_success.php");
      }
      else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
        echo db_error($db);
        db_close($db);
        unset($db);
        exit;
      }
    }
  }

  // if this is a POST request, process the form
  // Hint: private/functions.php can help

    // Confirm that POST values are present before accessing them.

    // Perform Validations
    // Hint: Write these in private/validation_functions.php

    // if there were no errors, submit data to database
    
      // Write SQL INSERT statement
      // $sql = "";

      // For INSERT statments, $result is just true/false
      //$result = db_query($db, $sql);
      //if($result) {
      //  db_close($db);

      //   TODO redirect user to success page

      // } else {
        // The SQL INSERT statement failed.
        // Just show the error, not the form
      //  echo db_error($db);
      //  db_close($db);
      //  exit;
      //}
?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

  <?php
    // TODO: display any form errors here
    // Hint: private/functions.php can help
    echo display_errors($errors);

  ?>

  <!-- TODO: HTML form goes here -->

  <form action="" method="post">
    First name:<br>
    <input type="text" name="firstname" value="<?php echo h($first_name); ?>"><br>
    Last name:<br>
    <input type="text" name="lastname" value="<?php echo h($last_name); ?>"><br>
    Email:<br>
    <input type="text" name="email" value="<?php echo h($email); ?>"><br>
    Username:<br>
    <input type="text" name="username" value="<?php echo h($username); ?>"><br>
    <input type="submit" name="submit" value="Submit">
  </form> 
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
