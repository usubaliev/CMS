<?php
    if(isset($_POST['create_user'])){
            
            $user_firstname     = escape($_POST['user_firstname']);
            $user_lastname      = escape($_POST['user_lastname']);
            $user_role          = escape($_POST['user_role']);
            $username           = escape($_POST['username']);
            $user_email         = escape($_POST['user_email']);
            $user_password      = escape($_POST['user_password']);

            $user_password      = password_hash($user_password , PASSWORD_BCRYPT, array('cost' => 10));
        
        $query = "INSERT INTO users(user_firstname, user_lastname, user_role, username, user_email, user_password) ";
        $query .= "VALUES ('{$user_firstname}','{$user_lastname}','{$user_role}','{$username}','{$user_email}','{$user_password}')";

        $create_user_query = mysqli_query($connection, $query);
        confirmQuery($create_user_query);
        
        echo "<div class='alert alert-success' role='alert'><b>$user_firstname $user_lastname</b> created as <b>$username</b>. " . " <a href='users.php'>View all users</a></div> ";
    }
?>

<form action="" method="post" enctype="multipart/form-data">
<!-- ecntype is for sending different form data -->
    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>


    <div class="form-group">
        <select name="user_role" id="">
            <option value="subscriber">Select...</option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
        </select>
    </div>
    <!--  <div class="form-group">
        <label for="post_image">Image</label>
        <input type="file" class="form-control" name="image">
    </div> -->

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_user" value="Create User">
    </div>
</form>