<?php

require __DIR__ . '/../src/Template.php';
require __DIR__ . '/../src/Database.php';
require __DIR__ . '/../models/User.php';

//Add code here

$message = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = isset($_POST['login']) ? $_POST['login'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    $conn = Database::getInstance()->getConnection();

    if(!is_null($login) &&
        is_null(User::getByUsername($conn,$login)) &&
        !is_null($password))
    {

        $user = new User();
        $user->setLogin($login);
        $user->setPassword($password);

        if($user->save($conn)) {
            header('Location: LoginController.php');
            exit();
        } else {
            $message = 'Not done';
        }

    } else {
        $message = 'Error data';
    }
}

//

$index = new Template(__DIR__ . '/../templates/index.tpl');

$content = new Template(__DIR__ . '/../templates/register.tpl');

$index->add('content', $content->parse());

echo $index->parse();
