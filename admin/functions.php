<?php 
//  C   -   Creat
//  R   -   Read
//  U   -   Update
//  D   -   Delete

// ======== DATABASE HELPER FUNCTIONS ======== //
function query($query){
    global $connection;
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    return $result;
}

function fetchRecords($result){
    return mysqli_fetch_array($result);
}
function count_records($result){
    return mysqli_num_rows($result);
}

// ======== end of DATABASE HELPERS  ======== //

// ======== GENERAL HELPERS ======== //
function confirmQuery($result){
    global $connection;
    if (!$result) {
        die("Query failed ." . mysqli_error($connection));
    } 
}

function get_user_name(){
    return isset($_SESSION['username']) ? $_SESSION['username'] : null;
}
// ======== end of GENERAL HELPERS ======== //

// ======== AUTHENTICATION HELPER ======== //
function is_admin(){
    if(isLoggedIn()){
        $result = query("SELECT user_role FROM users WHERE user_id=".$_SESSION['user_id']."");
        $row = fetchRecords($result);

        if ($row['user_role'] == 'admin') {
            return true;
        } else {
            return false;
        }
    } return false;
}
// ======== end of AUTHENTICATION HELPER ======== //

// ======== USER SPECIFIC HELPERS ======== //
function get_all_user_posts(){
    return query("SELECT * FROM posts WHERE user_id=".loggedInUserId()."");
}

function get_all_posts_user_comments(){
    return query("SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id WHERE user_id=".loggedInUserId()."");
}

function get_all_user_categories(){
    return query("SELECT * FROM categories WHERE user_id=".loggedInUserId()."");
}

function get_all_user_published_posts(){
    return query("SELECT * FROM posts WHERE user_id=".loggedInUserId()." AND post_status = 'published'");
}

function get_all_user_draft_posts(){
    return query("SELECT * FROM posts WHERE user_id=".loggedInUserId()." AND post_status = 'draft'");
}

function get_all_user_approved_posts_comments(){
    return query("SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id WHERE user_id=".loggedInUserId()." AND comment_status='approved'");
}

function get_all_user_unapproved_posts_comments(){
    return query("SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id WHERE user_id=".loggedInUserId()." AND comment_status='unapproved'");
}

// ======== end of USER SPECIFIC HELPERS ======== //

function currentUser(){
    if (isset($_SESSION['username'])) {
        return $_SESSION['username'];
    } 
    return false;
}

function redirect ($location) {
    header("Location: " . $location);
    exit;
}
function ifItIsMethod($method=null){

    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){
        return true;
    }
    return false;
}
function isLoggedIn(){

    if(isset($_SESSION['user_role'])){
        return true;
    }
    return false;
}
function loggedInUserId(){
    if(isLoggedIn()){
        $result = query("SELECT * FROM users WHERE username='" . $_SESSION['username'] ."'");
        confirmQuery($result);
        $user = mysqli_fetch_array($result);
        return mysqli_num_rows($result) >= 1 ? $user['user_id'] : false;
    }
    return false;
}

// Detect if user logged in user liked the post
function userLikedThisPost($post_id ){
    $result = query("SELECT * FROM likes WHERE user_id=" .loggedInUserId() . " AND post_id={$post_id}");
    confirmQuery($result);
    return mysqli_num_rows($result) >= 1 ? true : false;
}

// GET TOTAL POST LIKES
function getPostlikes($post_id){
    $result = query("SELECT * FROM likes WHERE post_id=$post_id");
    confirmQuery($result);
    echo mysqli_num_rows($result);
}

// Checking if user logged in and redirect
function checkIfUserIsLoggedInAndRedirect($redirectLocation=null){
    if(isLoggedIn()){
        redirect($redirectLocation);
    }
}

// Use default post image if there is none
function imagePlaceholder($image = ''){
    if (!$image) {
        return 'placeholderimage.jpg';
    } else {
        return $image;
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
// Find all categories query
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
// Delete category query
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
// dashboard posts, comments, users and categories huge icon and numbers

    function recordCount($table){ 
        // we changed this at Lecture 44:330 (Create seperate Admin dashboard for logged in users) 
        // to a count_records at the top of this file.

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

                    $_SESSION['user_id']        = $db_user_id;
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
