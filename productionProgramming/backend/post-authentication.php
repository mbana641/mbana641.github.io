<?php 
require_once("../assets/DB.class.php");
$response = [];
$postData = json_decode($_POST['data'], true);

if(isset($postData["username"]) && isset($postData["password"])){
    $db = new DB();
    if (!$db->getConnStatus()) {
        print "An error has occurred with connection\n";
        exit;
    }

    $password = filter_var($postData['password'], FILTER_SANITIZE_STRING);
    $username = filter_var($postData['username'], FILTER_SANITIZE_STRING);
    $username = $db->dbEsc($username);

    $query = "SELECT *
                    FROM user, role, user2role
                    WHERE user.username='$username' and user.id=user2role.userid and user2role.roleid=role.id";

    $userResults = $db->dbCall($query);
    if (sizeof($userResults) > 0) {
        
        session_start();
        $validPass = password_verify($password, $userResults[0]['userpass']); 
        
        if ($validPass) {
            $response['user'] = $userResults[0]['realname'];
            $roles = [];
            foreach ((array) $userResults as $role) {
                array_push($roles, $role['rolename']);
            }
            $response['roles'] = $roles;
            $response['status'] = 'success';
            print json_encode($response, true);

        } else {
            $response['status'] = 'fail';
            $response['message'] = 'Invalid username or password';
            print json_encode($response, true);
        }

    } else {
        $response['status'] = 'fail';
        $response['message'] = 'Invalid username or password';
        print json_encode($response, true);
    }

}



?>