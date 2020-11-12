<?php

session_start();

if(isset($_SESSION['login'])){
    require __DIR__ . '/../src/Template.php';
    require __DIR__ . '/../src/Database.php';
    require __DIR__ . '/../models/Conversation.php';
    require __DIR__ . '/../models/Message.php';

    $conn = Database::getInstance()->getConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'GET'){

        $openConversations = Conversation::loadAllConversations($conn);

        if (!empty($openConversations)){
            foreach ($openConversations as $openConv) {
                $row = new Template(__DIR__ . '/../templates/open_conversation.tpl');
                $row->add('conversationSubject',$openConv->getSubject());
                $row->add('conversationId',$openConv->getId());
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


        $index = new Template(__DIR__ . '/../templates/index.tpl');

        $content = new Template(__DIR__ . '/../templates/support_content.tpl');

        $content->add('conversations', $convContent);

        $content->add('openConversations',$rowsContent);

        $index->add('content', $content->parse());

        echo $index->parse();
    }

}else{
    header('Location: LoginController.php');
    exit();
}

