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
                echo "Nu s-a adaugat conversatia";
            }

        } else {
            $sql = "UPDATE `conversations` SET `subject` = :subject, `client_id`= :client_id, `support_id`= :support_id 
                    WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'id'=>$this->id,
                'subject'=>$this->subject,
                'client_id'=>$this->client_id,
                'support_id'=>$this->support_id,
            ]);

            if($result) {
                return true;
            }
            else{
                echo "Nu s-a executat update";
            }
        }

        return false;
    }

    public static function loadAllConversations(PDO $db, $id = null)
    {
        $params = [];
        if (!$id) {
            $sql = "SELECT * FROM conversations";
        } else {
            $sql = "SELECT * FROM conversations WHERE id=:id";
            $params = ['id' => $id];
        }
        $stmt = $db->prepare($sql);
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
            $conversation->setClientId($record['clientId']);
            $conversation->setSupportId($record['supportId']);

            return $conversation;
        }

        return null;

    }

    public function delete(PDO $conn, int $id)
    {
        $sql = "DELETE FROM `conversations` WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['id'=>$id]);

        if($result){
            echo "s-a sters conversatia cu id ".$id;
            return true;
        }else{
            echo "Nu s-a sters";
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