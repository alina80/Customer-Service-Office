<?php

session_start();

if (isset($_SESSION['login'])){
    require __DIR__. '/../models/User.php';
    require __DIR__ . '/../src/Template.php';
    require __DIR__ . '/../src/Database.php';
    require __DIR__ . '/../models/Conversation.php';
    require __DIR__ . '/../models/Message.php';

    $id = $_SESSION['id'];

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $subject = isset($_POST['messageSubject']) ? $_POST['messageSubject'] : null;
        $textMessage = isset($_POST['message']) ? $_POST['message'] : null;

        $conn = Database::getInstance()->getConnection();

        $userRole = (User::getById($conn,$_SESSION['id']))->getRole();

        if(!is_null($subject) && !is_null($textMessage))
        {
            $message = new Message();
            $message->setConversationId($subject);
            $message->setSenderId($id);
            $message->setMessage($textMessage);

            if($message->saveMessage($conn)) {
                if ($userRole === 0){
                    header('Location: ClientController.php');
                    exit();
                }
                if ($userRole === 1){
                    header('Location: SupportController.php');
                    exit();
                }

            } else {
                $message = 'Not done';
            }

        } else {
            $message = 'Error data';
        }
    }

    $index = new Template(__DIR__ . '/../templates/index.tpl');

    $content = new Template(__DIR__ . '/../templates/register.tpl');

    $index->add('content', $content->parse());

    echo $index->parse();
}else{
    echo "Not allowed! Please login first!";
}