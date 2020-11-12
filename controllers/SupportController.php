<?php

session_start();

if(isset($_SESSION['login'])){
    require __DIR__ . '/../src/Template.php';
    require __DIR__ . '/../src/Database.php';
    require __DIR__ . '/../models/Conversation.php';
    require __DIR__ . '/../models/Message.php';
    require __DIR__ . '/../models/User.php';

    $conn = Database::getInstance()->getConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        $rowsTemplate = [];
        $convTemplate = [];
        $optionsTemplate = [];
        $messTemplate = [];

        $openConversations = Conversation::loadAllOpenConversations($conn);

        if (!empty($openConversations)){
            foreach ($openConversations as $openConv) {
                $row = new Template(__DIR__ . '/../templates/open_conversation.tpl');
                $row->add('conversationSubject', $openConv->getSubject());
                $row->add('conversationId', $openConv->getId());
                $row->add('clientId', $openConv->getClientId());
                $rowsTemplate[] = $row;
            }
        }
        $rowsContent = Template::joinTemplates($rowsTemplate);

        $conversations = Conversation::loadAllConversationsBySupportId($conn, $_SESSION['id']);

        if (!empty($conversations)){
            foreach ($conversations as $conv){
                $convRow = new Template(__DIR__ . '/../templates/conversation.tpl');
                $convRow->add('subject', $conv->getSubject());
                $convTemplate[] = $convRow;
            }
        }
        $convContent = Template::joinTemplates($convTemplate);

        $options = Conversation::loadAllConversationsBySupportId($conn, $_SESSION['id']);

        if(!empty($options)){
            foreach ($options as $opt){
                $option = new Template(__DIR__ . '/../templates/option.tpl');
                $option->add('conversationId',$opt->getId());
                $option->add('subject',$opt->getSubject());
                $optionsTemplate[] = $option;
            }
        }
        $optionsContent = Template::joinTemplates($optionsTemplate);

        $convMess = Conversation::loadAllConversationsBySupportId($conn,$_SESSION['id']);

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

        $index = new Template(__DIR__ . '/../templates/index.tpl');

        $content = new Template(__DIR__ . '/../templates/support_content.tpl');

        $content->add('conversations', $convContent);

        $content->add('openConversations',$rowsContent);

        $content->add('options', $optionsContent);

        $content->add('messages', $messagesContent);

        $index->add('login',$_SESSION['login']);

        $index->add('content', $content->parse());

        echo $index->parse();
    }

}else{
    header('Location: LoginController.php');
    exit();
}

