<?php 
//  C   -   Creat
//  R   -   Read
//  U   -   Update
//  D   -   Delete

function currentUser(){
    if (isset($_SESSION['username'])) {
        return $_SESSION['username'];
    } 
    return false;
}

// // HELPER FUNCTIONS - Exiting what we are doing, not going to return anything.
function redirect ($location) {
    header("Location: " . $location);
    exit;
  }

// HELPER FUNCTIONS - 
function ifItIsMethod($method=null){

    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){
        return true;
    }
    return false;
}

// HELPER FUNCTIONS - if a user already logged in
function isLoggedIn(){

    if(isset($_SESSION['user_role'])){
        return true;
    }
    return false;
}

// HELPER FUNCTIONS - Checking if user logged in and redirect
function checkIfUserIsLoggedInAndRedirect($redirectLocation=null){
    if(isLoggedIn()){
        redirect($redirectLocation);
    }
}


// More security!!!
function escape($string){
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}

//Users online
function users_online() {
    if(isset($_GET['onlineusers'])) {

        global $connection;

            if(!$connection) {
            session_start();
            include("../includes/db.php");

            $session = session_id();
            $time = time();
            $time_out_in_seconds = 05;
            $time_out = $time - $time_out_in_seconds;

            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);

                if($count == NULL) {
                    mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session','$time')");
                } else {
                    mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
                }
            $users_online_query =  mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
            echo $count_user = mysqli_num_rows($users_online_query);
        }
    } // get request isset()
} users_online();

// Tired typing same "checking for erros code" 
function confirmQuery($result){
    global $connection;
    if (!$result) {
        die("Query failed ." . mysqli_error($connection));
    } 
}

// INSERT CATEGORIES with PREPARE STATEMENT
function insert_categories(){
        global $connection;

        if (isset($_POST['submit'])) {
        $cat_title = escape($_POST['cat_title']); 

        if ($cat_title == "" || empty($cat_title)) {
            echo "<div class='alert alert-danger' role='alert'>Category name cannot be empty!</div>";
        } else {
            $stmt = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUES(?) ");
            
            mysqli_stmt_bind_param($stmt, 's', $cat_title);
            mysqli_stmt_execute($stmt);

            if(!$stmt){
                die('QUERY FAILED' . mysqli_error($connection, $stmt));
            }
        }
        //mysqli_stmt_close($stmt); - getting errors if we uncomment this stmt_close. Fix by EdwinDiaz.
    }
}
// FIND ALL CATEGORIES QUERY
function findAllCategories(){ 
    global $connection;

    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection , $query);

        while ($row = mysqli_fetch_assoc($select_categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        
        echo "<tr>";
        echo "<td class='text-right'> {$cat_id} </td>";
        echo "<td> {$cat_title} </td>";
        echo "<td class='text-center'><a class='btn btn-info btn-sm' href='categories.php?edit={$cat_id}'>Rename</a></td>";
        echo "<td class='text-center'><a class='btn btn-danger btn-sm' href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "</tr>";
    }
}
// DELETE CATEGORY QUERY
    function delete_categories(){
    global $connection;

        if (isset($_GET['delete'])) {
            $the_cat_id = $_GET['delete'];
            $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id}";
            $delete_query = mysqli_query($connection , $query);
            header("Location: categories.php"); 
        }
    }


// refactoring for admin/index.php to minimize our HTML
// dashboard posts, comments, users and categories huge icon and number

        function recordCount($table){
            global $connection;

            $query = "SELECT * FROM " . $table;
            $select_all_posts = mysqli_query($connection, $query);

            $result = mysqli_num_rows($select_all_posts);
            
            confirmQuery($result);

            return $result;
            // can be compact like this: return mysqli_num_rows($select_all_posts);
        }
            // Published posts, Draft posts and Comments status query minimized.
        function checkStatus($table, $column, $status){
            global $connection;

            $query = "SELECT * FROM $table WHERE $column = '$status' ";
            $result = mysqli_query($connection, $query);
            
            return mysqli_num_rows($result);

        }
        
        // User role query minimized.
        function checkUserRole($table, $column, $role){
            global $connection;

            $query = "SELECT * FROM $table WHERE $column = '$role' ";
            $select_all_subscribers = mysqli_query($connection, $query);
            
            return mysqli_num_rows($select_all_subscribers);

        }
        
        // is_admin function to restrict subscribers viewing draft pages
        function is_admin($username){
            global $connection;

            $query = "SELECT user_role FROM users WHERE username = '$username' ";
            $result = mysqli_query($connection, $query);

            confirmQuery($result);

            $row = mysqli_fetch_array($result);

            if (isset($row['user_role']) == 'admin') {
                return true;
            } else {
                return false;
            }

        }

        // Username exists
        function username_exists($username){
            global $connection;

            $query = "SELECT username FROM users WHERE username = '$username' ";
            $result = mysqli_query($connection, $query);

            confirmQuery($result);

            if (mysqli_num_rows($result) > 0) {
                return true;
            } else {
                return false;
            }
        }


        // Username exists
        function email_exists($email){ 
            global $connection;

            $query = "SELECT user_email FROM users WHERE user_email = '$email' ";
            $result = mysqli_query($connection, $query);

            confirmQuery($result);

            if (mysqli_num_rows($result) > 0) {
                return true;
            } else {
                return false;
            }
        }

        // NEW user registration function (removed from registration.php)
        function register_user($username, $email, $password){
            global $connection;
            
        /*  $username   = escape($_POST['username']);
            $email      = escape($_POST['email']);
            $password   = escape($_POST['password']); */
    
                $username   = mysqli_real_escape_string($connection, $username);
                $email      = mysqli_real_escape_string($connection, $email);
                $password   = mysqli_real_escape_string($connection, $password);
    
                $password = password_hash($password , PASSWORD_BCRYPT, array('cost' => 12));
    
                $query = "INSERT INTO users (username, user_email, user_password, user_role) ";
                $query .= "VALUES ('{$username}', '{$email}', '{$password}', 'subscriber' )";
                $register_user_query = mysqli_query($connection, $query);

                confirmQuery($register_user_query);
        }

        // NEW login user 
        function login_user($username, $password){
            global $connection;
           
            $username   = trim($username);
            $password   = trim($password);
            
            $username = mysqli_real_escape_string($connection, $username);
            $password = mysqli_real_escape_string($connection, $password);
    
            $query = "SELECT * FROM users WHERE username = '{$username}' ";
            $select_user_query = mysqli_query($connection, $query);
    
            if (!$select_user_query) {
                die("Query Failed!" . mysqli_error($connection));
            }
            
                while ($row = mysqli_fetch_array($select_user_query)) {
                    $db_user_id         = $row['user_id'];
                    $db_username        = $row['username'];
                    $db_user_password   = $row['user_password'];
                    $db_user_firstname  = $row['user_firstname'];
                    $db_user_lastname   = $row['user_lastname'];
                    $db_user_role       = $row['user_role'];  

                    // revers crypt function 
                    //$password = crypt($password, $db_user_password);

                    if (password_verify($password, $db_user_password) ) {
                        $_SESSION['username']       = $db_username;
                        $_SESSION['firstname']      = $db_user_firstname;
                        $_SESSION['lastname']       = $db_user_lastname;
                        $_SESSION['user_role']      = $db_user_role;
                        
                        redirect("/cms/admin");
                        
                    } else {
                        return false;
                    }
                
                } return true;
        }
        

?>      
