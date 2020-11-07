<?php

session_start();

require __DIR__ . '/../src/Template.php';
require __DIR__ . '/../src/Database.php';
require __DIR__ . '/../models/User.php';

//Add code here

$message = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = isset($_POST['login']) ? $_POST['login'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    if(!is_null($login) && !is_null($password)) {

        $conn = Database::getInstance()->getConnection();
        $user = User::loginUser($conn,$login,$password);


        if(!is_null($user)) {
            $_SESSION['id'] = $user->getId();
            $_SESSION['login'] = $user->getLogin();

            if ($user->getRole() == 0){
                header('Location: ClientController.php');
                exit();
            }elseif ($user->getRole() == 1){
                header('Location: SupportController.php');
                exit();
            }


        } else {
            $message = 'Wrong username or password';
        }

    } else {
        $message = 'Error data';
    }
}

//

$index = new Template(__DIR__ . '/../templates/index.tpl');

$content = new Template(__DIR__ . '/../templates/login.tpl');

$index->add('content', $content->parse());

echo $index->parse();
