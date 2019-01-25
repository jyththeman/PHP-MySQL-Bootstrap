<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $new_user = array(
      "firstname" => $_POST['firstname'],
      "lastname"  => $_POST['lastname'],
      "email"     => $_POST['email'],
      "age"       => $_POST['age'],
      "location"  => $_POST['location']
    );

    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "users",
      implode(", ", array_keys($new_user)),
      ":" . implode(", :", array_keys($new_user))
    );
    
    $statement = $connection->prepare($sql);
    $statement->execute($new_user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote><?php echo escape($_POST['firstname']); ?> successfully added.</blockquote>
  <?php endif; ?>

  <h2>Add a user</h2>

<div class="container">
  <h2>User Information</h2>
  <form class="form-horizontal" method="post">
    <div class="form-group">
      <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
      <label class="control-label col-sm-2" for="firstname">First Name: </label>
        <div class="col-sm-5">
      <input type="text" class="form-control" name="firstname" id="firstname">
            </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="lastname">Last Name: </label>
        <div class="col-sm-5">
      <input type="text" class="form-control" name="lastname" id="lastname">
            </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Email Address: </label>
        <div class="col-sm-5">
      <input type="text" class="form-control" name="email" id="email">
            </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="age">Age: </label>
        <div class="col-sm-5">
      <input type="text" class="form-control" name="age" id="age">
            </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="location">Location: </label>
        <div class="col-sm-5">
      <input type="text" class="form-control" name="location" id="location">
            </div>
    </div>
   <div class="form-group">
      <div class="col-sm-offset-2 col-sm-2">
       <button type="submit" class="form-control" name="submit" value="Submit">Submit</button>
       </div>
       
      </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-2">
       <a href="index.php">Back to home</a>
       </div>
       
      </div>
      
      
  </form>
    
</div>

  

<?php require "templates/footer.php"; ?>
