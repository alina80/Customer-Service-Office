<?php
class Conversation {

    private $id;
    private $subject;
    private $client_id;
    private $support_id;


    public function __construct()
    {
        $this->id = -1;
        $this->subject = "";
        $this->client_id = $this->getClientId();
        $this->support_id = null;
    }

    public function saveConversation(PDO $conn) {
        if($this->id === -1) {

            $sql = "INSERT INTO `conversations` SET `subject` = :subject, `client_id`= :client_id, `support_id`= :support_id";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'subject'=>$this->subject,
                'client_id'=>$this->client_id,
                'support_id'=>$this->support_id
            ]);

            if($result) {
                $this->setId($conn->lastInsertId());
                return true;
            }
            else{
                echo "The conversation could not be added!";
            }
        }
        return false;
    }

    public function update(PDO $conn, $id)
    {
            $sql = "UPDATE `conversations` SET `subject` = :subject, `client_id`= :client_id, `support_id`= :support_id 
                    WHERE id = :id";
            $stmt = $conn->prepare($sql);
            echo $this->client_id;
            echo $this->support_id;
            echo $this->subject;
            $result = $stmt->execute([
                'id'=>$id,
                'subject'=>$this->subject,
                'client_id'=>$this->client_id,
                'support_id'=>$this->support_id,
            ]);

            if($result) {
                return true;
            }
            else{
                echo "The conversation could not be updated!";
                return false;
            }
    }

    public static function loadAllConversations(PDO $conn, $id = null)
    {
        $params = [];
        if (!$id) {
            $sql = "SELECT * FROM `conversations`";
        } else {
            $sql = "SELECT * FROM `conversations` WHERE `id`=:id";
            $params = ['id' => $id];
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        $conversations = $stmt->fetchAll(PDO::FETCH_OBJ);

        $conversationsList = [];

        foreach ($conversations as $dbConversations) {
            $conversation = new Conversation();
            $conversation->id = $dbConversations->id;
            $conversation->client_id =$dbConversations->client_id;
            $conversation->support_id =$dbConversations->client_id;
            $conversation->subject = $dbConversations->subject;

            $conversationsList[] = $conversation;
        }

        return $conversationsList;
    }

    public static function getConversationById(PDO $conn, int $conversation_id) {
        $sql = "SELECT * FROM `conversations` WHERE `id` = :conversation_id";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['conversation_id'=>$conversation_id]);

        if($result && $stmt->rowCount() > 0) {
            $record = $stmt->fetch(PDO::FETCH_ASSOC);

            $conversation = new Conversation();
            $conversation->setId($record['id']);
            $conversation->setSubject($record['subject']);
            $conversation->setClientId($record['client_id']);
            $conversation->setSupportId($record['support_id']);

            return $conversation;
        }

        return null;

    }

    public static function loadAllConversationsByClientId(PDO $conn, $client_id = null){
        $params = [];
        if (!$client_id){
            $sql = "SELECT * FROM `conversations`";
        }else {
            $sql = "SELECT * FROM `conversations` WHERE `client_id` =:client_id";
            $params = ['client_id' => $client_id];
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        $conversations = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conversationsList = [];

        foreach ($conversations as $dbConversations) {
            $conversation = new Conversation();
            $conversation->id = $dbConversations->id;
            $conversation->client_id =$dbConversations->client_id;
            $conversation->support_id =$dbConversations->client_id;
            $conversation->subject = $dbConversations->subject;

            $conversationsList[] = $conversation;
        }

        return $conversationsList;
    }

    public static function loadAllConversationsBySupportId(PDO $conn, $support_id = null){
        $params = [];
        if (!$support_id){
            $sql = "SELECT * FROM `conversations`";
        }else {
            $sql = "SELECT * FROM `conversations` WHERE `support_id` =:support_id";
            $params = ['support_id' => $support_id];
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        $conversations = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conversationsList = [];

        foreach ($conversations as $dbConversations) {
            $conversation = new Conversation();
            $conversation->id = $dbConversations->id;
            $conversation->client_id =$dbConversations->client_id;
            $conversation->support_id =$dbConversations->client_id;
            $conversation->subject = $dbConversations->subject;

            $conversationsList[] = $conversation;
        }

        return $conversationsList;
    }

    public function delete(PDO $conn, int $id)
    {
        $sql = "DELETE FROM `conversations` WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['id'=>$id]);

        if($result){
            echo "The conversation with id " . $id . " was deleted!";
            return true;
        }else{
            echo "The conversation was not deleted!";
            return false;
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * @param mixed $client_id
     */
    public function setClientId($client_id): void
    {
        $this->client_id = $client_id;
    }

    /**
     * @return mixed
     */
    public function getSupportId()
    {
        return $this->support_id;
    }

    /**
     * @param mixed $support_id
     */
    public function setSupportId($support_id): void
    {
        $this->support_id = $support_id;
    }



}