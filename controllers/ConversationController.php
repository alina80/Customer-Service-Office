<?php

session_start();

if (isset($_SESSION['login'])){
    require __DIR__. '/../models/User.php';
    require __DIR__ . '/../src/Template.php';
    require __DIR__ . '/../src/Database.php';
    require __DIR__ . '/../models/Conversation.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $subject = isset($_POST['subject']) ? $_POST['subject'] : null;
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $client_id = isset($_POST['client_id']) ? $_POST['client_id'] : null;


        $conn = Database::getInstance()->getConnection();

        if(!is_null($subject) && is_null($id) && is_null($client_id))
        {
            $client_id = $_SESSION['id'];
            $conversation = new Conversation();
            $conversation->setSubject($subject);
            $conversation->setClientId($client_id);

            if($conversation->saveConversation($conn)) {
                header('Location: ClientController.php');
                exit();
            } else {
                $message = 'not done';
            }

        } elseif (!is_null($subject) && !is_null($id) && !is_null($client_id)) {

            $support_id = $_SESSION['id'];

            $conversation = new Conversation();
            $conversation->setId($id);
            $conversation->setClientId($client_id);
            $conversation->setSupportId($support_id);
            $conversation->setSubject($subject);

            if ($conversation->update($conn, $id)){
                header('Location: SupportController.php');
                exit();
            }else{
                $message = 'error data';

            }
        }
    }

    $index = new Template(__DIR__ . '/../templates/index.tpl');

    $content = new Template(__DIR__ . '/../templates/register.tpl');

    $index->add('content', $content->parse());

    echo $index->parse();
}else{
    echo "Not allowed! Please login first!";
}