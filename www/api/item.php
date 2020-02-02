<?php
    
    if(session_id() == '') {
        session_start();
    }

    require_once 'api.php';
    
    if (empty($selectingDatabase)) {
        $thisDir = dirname(__FILE__);
        require( dirname($thisDir) . '/db_operations/db_connection.php');
    }

    class ItemController extends API
    {

        /**
         * Example of an Endpoint
         */
         protected function item($args, $file) {
                    $db_username = "png";
                    $db_password = "png";
                    $db_hostname = "mysql"; 
                    $db_db = "png";

                    $connect = mysqli_connect($db_hostname, $db_username, $db_password, $db_db);

            if(!isset($_SESSION['user_id'])) {
                return "User not Authenticated! You must be logged in to view this resource.";
            }

            if ($this->method == 'GET') {

                if (sizeof($args) > 0) {

                    $id = $args[0];
                    
                    
                    $result = mysqli_query($connect,
                        "SELECT * from item where id = '" . $id . "'"
                    );

                    $itemExists = mysqli_num_rows($result);

                    if($itemExists < 1)
                        return "No item found with id: " . $args[0];

                    while ($row = mysqli_fetch_array($result)) 
                    {
                        $new_array[$row['id']]['id'] = $row['id'];
                        $new_array[$row['id']]['name'] = $row['name'];
                        $new_array[$row['id']]['price'] = $row['price'];
                    }

                    return $new_array;
                }
                
                
                $result = mysqli_query($connect,
                    "SELECT * from item"
                );

                while ($row = mysqli_fetch_array($result)) 
                {
                    $new_array[$row['id']]['id'] = $row['id'];
                    $new_array[$row['id']]['name'] = $row['name'];
                    $new_array[$row['id']]['price'] = $row['price'];
                }

                return $new_array;
            }

            if ($this->method == 'POST') {
                
                if (empty($_POST['name']) || empty($_POST['price'])){

                    $data = json_decode(file_get_contents('php://input'), true);

                    if (empty($data['name']) || empty($data['price'])) {
                        return "Name and price of the item to be added are required!";
                    }

                    $_POST['name'] = $data['name'];
                    $_POST['price'] = $data['price'];
                    
                }
                
                $name = $_POST['name'];
                $price = $_POST['price'];

                if($price < 0)
                    return "Price of your item can't be zero or negative! You don't want to sell it for free. Do you?";

                $result = mysqli_query($connect,
                    "INSERT INTO item (name, price) VALUES ( '" . $name . "', '"
                         . $price . "')"
                );

                if(!$result)
                    return "Error adding item!";

                else
                    return "Item added successfully!";

            }

            if ($this->method == 'PUT') {

                $data = json_decode($file, true);

                if(empty($data['name']) || empty($data['price']))
                    return "Name and price of the item to be updated are required!";
                
                $name = $data['name'];
                $price = $data['price'];

                if($price < 0)
                    return "Price of your item can't be zero or negative! You don't want to sell it for free. Do you?";

                if (sizeof($args) > 0) {
                    
                    $id = $args[0];

                    $result = mysqli_query($connect,
                        "UPDATE item set name = '" . $name . "' , price = '" . 
                        $price . "' where id = '" . $id . "'"
                    );

                    if(!$result)
                        return "Error updating item!";
                    else if(mysqli_affected_rows($connect) < 1)
                        return "No item updated, possibly item not found with id: " . $id . "!";
                    else
                        return "Item updated successfully!";

                }

                return "'id' of the item to be updated is required. Add it to the end of url";
            }

            if ($this->method == 'DELETE') {
                
                if (sizeof($args) > 0) {
                    $id = $args[0];

                    $result = mysqli_query($connect,
                        "DELETE from item where id = '" . $id . "'"
                    );

                    if(!$result)
                        return "Error deleting item!";
                    else if(mysqli_affected_rows($connect) < 1)
                        return "No item deleted, possibly item not found with id: " . $id . "!";
                    else
                        return "Item deleted successfully!";
                }

                return "'id' of the item to be deleted is required. Add it to the end of url";
            }
         }
     }
?>