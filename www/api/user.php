<?php
        
    if(session_id() == '') {
        session_start();
    }

    require_once 'api.php';

    if (empty($selectingDatabase)) {
        $thisDir = dirname(__FILE__);
        require( dirname($thisDir) . '/db_operations/db_connection.php');
    }

    function mysqli_result($res,$row=0,$col=0){ 
    $numrows = mysqli_num_rows($res); 
    if ($numrows && $row <= ($numrows-1) && $row >=0){
        mysqli_data_seek($res,$row);
        $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
        if (isset($resrow[$col])){
            return $resrow[$col];
        }
    }
    return false;
}

    class UserController extends API
    {

        /**
         * Example of an Endpoint
         */
         protected function user() {
            if ($this->method == 'GET') {

                if(!isset($_SESSION['user_id'])) {
                    return "User not Authenticated! You must be logged in to view this resource.";
                }

                $id = $_SESSION['user_id'];
                $db_username = "png";
                $db_password = "png";
                $db_hostname = "mysql"; 
                $db_db = "png";

                $connect = mysqli_connect($db_hostname, $db_username, $db_password, $db_db);
                
                $result = mysqli_query($connect,
                    "SELECT * from user where id = '" . $id . "'"
                );

                while ($row = mysqli_fetch_array($result)) 
                {
                    $new_array[$row['id']]['id'] = $row['id'];
                    $new_array[$row['id']]['username'] = $row['username'];
                }

                return $new_array;


            } else {
                return "Only accepts GET requests";
            }
         }

         protected function login() {

            if ($this->method == 'POST') {
                
                if (empty($_POST['username']) || empty($_POST['password'])) {
                    
                    $data = json_decode(file_get_contents('php://input'), true);

                    if (empty($data['username']) || empty($data['password'])) {
                        return "Username or Password not provided!";
                    }

                    $_POST['username'] = $data['username'];
                    $_POST['password'] = $data['password'];
                }

                $username = $_POST['username'];
                $password = $_POST['password'];

                $password = sha1($password);
                $db_username = "png";
                $db_password = "png";
                $db_hostname = "mysql"; 
                $db_db = "png";

                $connect = mysqli_connect($db_hostname, $db_username, $db_password, $db_db);

                $result = mysqli_query($connect,
                    "SELECT id from user where username = '" . $username . "' && password = '"
                    . $password . "'"
                );

                $login = mysqli_num_rows($result);

                if($login > 0){
                    $user_id =  mysqli_result($result, 0);
                    $_SESSION['user_id'] = $user_id;

                    return "Successful login!";
                }
                
                return "Invalid Credentials! $username - $password";
                
                
            } else {
                return "Only accepts POST requests";
            }
        }

        protected function logout() {
            
            if(!isset($_SESSION['user_id'])) {
                return "Not LoggedIn!";
            }

            $_SESSION['user_id'] = null;
            return "Successfully Logged Out!";
        }
     }
?>