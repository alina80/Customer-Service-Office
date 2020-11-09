<?php

class Message{

    private $id;
    private $conversation_id;
    private $sender_id;
    private $message;

    public function __construct()
    {
        $this->id = -1;
        $this->conversation_id = $this->getConversationId();
        $this->sender_id = $this->getSenderId();
        $this->message = '';
    }

    public static function getMessageById(PDO $conn, int $message_id)
    {
        $sql = "SELECT * FROM `messages` WHERE `id` = :message_id";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['message_id' => $message_id]);

        if($result && $stmt->rowCount() > 0) {
            $record = $stmt->fetch(PDO::FETCH_ASSOC);
            $message = new Message();
            $message->setId($record['id']);
            $message->setConversationId($record['conversation_id']);
            $message->setSenderId($record['sender_id']);
            $message->setMessage($record['message']);

            return $message;
        }
        return null;
    }

    public static function loadAllMessagesByConversationId(PDO $conn,int $conversation_id)
    {
        $sql = "SELECT * FROM `messages` WHERE `conversation_id` = :conversation_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['conversation_id' => $conversation_id]);

        $messages = $stmt->fetchAll(PDO::FETCH_OBJ);
        $messagesList = [];

        foreach ($messages as $dbMessages){
            $message = new Message();
            $message->id = $dbMessages->id;
            $message->conversation_id = $dbMessages->conversation_id;
            $message->sender_id = $dbMessages->sender_id;
            $message->message = $dbMessages->message;

            $messagesList[] = $message;
        }
        return $messagesList;
    }

    public function saveMessage(PDO $conn)
    {
        if($this->id === -1) {
            $sql = "INSERT INTO `messages` SET `conversation_id` = :conversation_id, `sender_id`= :sender_id, `message`=:message";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'conversation_id' => $this->conversation_id,
                'sender_id' => $this->sender_id,
                'message' => $this->message
            ]);

            if($result) {
                $this->setId($conn->lastInsertId());
                return true;
            }else{
                echo "The message could not be added!";
            }

        } else {
            $sql = "UPDATE `messages` SET `conversation_id` = :conversation_id, `sender_id`= :sender_id, `message`= :message WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'conversation_id' => $this->conversation_id,
                'sender_id' => $this->sender_id,
                'message' => $this->message
            ]);

            if($result) {
                return true;
            }
        }

        return false;
    }

    public function delete(PDO $conn, int $id)
    {
        $sql = "DELETE FROM `messages` WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(
            [
                'id' => $this->id,
            ]
        );

        return $stmt->rowCount() > 0;
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
     * @return mixed
     */
    public function getConversationId()
    {
        return $this->conversation_id;
    }

    /**
     * @param mixed $conversation_id
     */
    public function setConversationId($conversation_id): void
    {
        $this->conversation_id = $conversation_id;
    }

    /**
     * @return mixed
     */
    public function getSenderId()
    {
        return $this->sender_id;
    }

    /**
     * @param mixed $sender_id
     */
    public function setSenderId($sender_id): void
    {
        $this->sender_id = $sender_id;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }



}