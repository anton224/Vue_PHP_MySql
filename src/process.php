<!-- PHP file for processing incoming requests -->
<!-- Manages interaction with database -->
<!-- Read, Create, Edit and Delete users -->

<?php
    # Establish connection
    $conn = new mysqli("localhost","root","","test");
    if($conn->connect_error){
        die("Connection Failed".$conn->connect_error);
    }
    $result = array('error'=>false);
    $action = '';


    if(isset($_GET['action'])){
        $action = $_GET['action'];
    }
    # --- Handle incoming request ---

    # Get all users
    if($action == 'read'){
        $sql = $conn->query("select * from users");
        $users = array();
        while($row = $sql->fetch_assoc()){
            array_push($users,$row);
        }
        $result['users'] = $users;
    }

    # Create new user
    if($action == 'create'){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $sql = $conn->query("insert into users (name,email,phone)
                            value('$name','$email','$phone')");
        if($sql){
            $result['message'] ='User added successfully!';
        }else{
            $result['error'] = true;
            $result['message'] = "Failed to Add User";
        }
        $users = array();
        while($row = $sql->fetch_assoc()){
            array_push($users,$row);
        }
        $result['users'] = $users;
    }

    # Update existing user
    if($action == 'update'){
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $sql = $conn->query("update users set name='$name',email='$email',phone='$phone'
            where id='$id'");
        if($sql){
            $result['message']='User updated successfully!';
        }else{
            $result['error'] = true;
            $result['message'] = "Failed to Update User";
        }
        $users = array();
        while($row = $sql->fetch_assoc()){
            array_push($users,$row);
        }
        $result['users'] = $users;
    }

    # Delete user
    if($action == 'delete'){
        $id = $_POST['id'];

        $sql = $conn->query("delete from users where id='$id'");
        if($sql){
            $result['message']='User deleted successfully!';
        }else{
            $result['error'] = true;
            $result['message'] = "Failed to Delete User";
        }
        $users = array();
        while($row = $sql->fetch_assoc()){
            array_push($users,$row);
        }
        $result['users'] = $users;
    }
    # Show result
    echo json_encode($result);

    # Alternative way
    /*
     * return response()->json(['result' => $result]);
     */

    # Close connection
    $conn->close();

?>
