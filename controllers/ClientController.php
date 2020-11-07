<?php

session_start();

if (isset($_SESSION['login'])) {

    require __DIR__ . '/../src/Template.php';
    require __DIR__ . '/../src/Database.php';
    require __DIR__ . '/../models/Conversation.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $subject = isset($_POST['subject']) && strlen(trim($_POST['subject'])) > 0 ?
            $_POST['subject'] : null;

        $conn = Database::getInstance()->getConnection();
        $id = $_SESSION['id'];

        if (!is_null($subject) && is_null(Conversation::getConversationById($conn,$id))) {
            $conversation = new Conversation();
            $conversation->setSubject($subject);
            $conversation->setClientId(User::getById($conn, $id));

            if ($conversation->saveConversation($conn)) {
                header('Location: controllers/ClientController.php');
                exit();
            } else {
                $message = 'not done';
            }
        }else{
            echo "error data";
        }

    }elseif ($_SERVER['REQUEST_METHOD'] === 'GET'){
        $conn = Database::getInstance()->getConnection();

        $conversations = Conversation::loadAllConversations($conn);

        foreach ($conversations as $conv) {
            $row = new Template(__DIR__ . '/../templates/conversation.tpl');
            $row->add('subject',$conv->getSubject());
            $rowsTemplate[] = $row;

        }

        $rowsContent = Template::joinTemplates($rowsTemplate);
    }

    $index = new Template(__DIR__ . '/../templates/index.tpl');

    $content = new Template(__DIR__ . '/../templates/client_content.tpl');

    $content->add('conversations',$rowsContent);

    $index->add('content', $content->parse());

    echo $index->parse();
}else{
    echo "Not allowed! Please login first!";
}