<?php

session_start();

if (isset($_SESSION['login'])){
    require __DIR__. '/../models/User.php';
    require __DIR__ . '/../src/Template.php';
    require __DIR__ . '/../src/Database.php';
    require __DIR__ . '/../models/Conversation.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $subject = isset($_POST['subject']) ? $_POST['subject'] : null;

        $conn = Database::getInstance()->getConnection();
        $id = $_SESSION['id'];

        if(!is_null($subject))
        {
            $conversation = new Conversation();
            $conversation->setSubject($subject);
            $conversation->setClientId($id);

            if($conversation->saveConversation($conn)) {
                header('Location: ClientController.php');
                exit();
            } else {
                $message = 'not done';
            }

        } else {
            $message = 'error data';
        }
    }

    $index = new Template(__DIR__ . '/../templates/index.tpl');

    $content = new Template(__DIR__ . '/../templates/register.tpl');

    $index->add('content', $content->parse());

    echo $index->parse();
}else{
    echo "Not allowed! Please login first!";
}