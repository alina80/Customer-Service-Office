<?php

session_start();

if (isset($_SESSION['login'])) {

    require __DIR__ . '/../src/Template.php';
    require __DIR__ . '/../src/Database.php';
    require __DIR__ . '/../models/Conversation.php';
    require __DIR__ . '/../models/Message.php';
    require __DIR__ . '/../models/User.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
//        $subject = isset($_POST['subject']) && strlen(trim($_POST['subject'])) > 0 ?
//            $_POST['subject'] : null;
//
//        $conn = Database::getInstance()->getConnection();
//        $id = $_SESSION['id'];
//
//        if (!is_null($subject) && is_null(Conversation::getConversationById($conn,$id))) {
//            $conversation = new Conversation();
//            $conversation->setSubject($subject);
//            $conversation->setClientId(User::getById($conn, $id));
//
//            if ($conversation->saveConversation($conn)) {
//                header('Location: controllers/ClientController.php');
//                exit();
//            } else {
//                $message = 'not done';
//            }
//        }else{
//            echo "error data";
//        }

    }elseif ($_SERVER['REQUEST_METHOD'] === 'GET'){
        $conn = Database::getInstance()->getConnection();

        $conversations = Conversation::loadAllConversationsByClientId($conn,$_SESSION['id']);

        if (!empty($conversations)){
            foreach ($conversations as $conv) {
                $row = new Template(__DIR__ . '/../templates/conversation.tpl');
                $row->add('subject',$conv->getSubject());
                $rowsTemplate[] = $row;
            }
        }

        $convMess = Conversation::loadAllConversationsByClientId($conn,$_SESSION['id']);

        foreach ($convMess as $conversation){
            $messages = Message::loadAllMessagesByConversationId($conn,$conversation->getId());

            if (!empty($messages)){
                foreach ($messages as $mess){
                    $messageRow = new Template(__DIR__ . '/../templates/message.tpl');
                    $userName = User::getById($conn,$mess->getSenderId())->getLogin();
                    $messageRow->add('messageSender',$userName);
                    $messageRow->add('messageText',$mess->getMessage());

                    $messTemplate[] = $messageRow;
                }
            }
        }

        $messagesContent = Template::joinTemplates($messTemplate);

        $rowsContent = Template::joinTemplates($rowsTemplate);

        $options = Conversation::loadAllConversationsByClientId($conn,$_SESSION['id']);

        if (!empty($options)){

            foreach ($options as $opt) {
                $option = new Template(__DIR__ . '/../templates/option.tpl');
                $option->add('conversationId',$opt->getId());
                $option->add('subject',$opt->getSubject());
                $optionsTemplate[] = $option;
            }
        }
        $optionsContent = Template::joinTemplates($optionsTemplate);
    }

    $index = new Template(__DIR__ . '/../templates/index.tpl');

    $content = new Template(__DIR__ . '/../templates/client_content.tpl');

    $content->add('conversations',$rowsContent);

    $content->add('messages', $messagesContent);

    $content->add('options',$optionsContent);

    $index->add('login',$_SESSION['login']);

    $index->add('content', $content->parse());

    echo $index->parse();
}else{
    header('Location: LoginController.php');
    exit();
}