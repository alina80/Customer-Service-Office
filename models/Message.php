<?php

class Message{

    private $id;
    private $conversationId;
    private $senderId;
    private static $conn;

    public function __construct(PDO $conn)
    {
        self::$conn = $conn;
        $this->id = -1;
        $this->conversationId = $this->getConversationId();
        $this->senderId = $this->getSenderId();
    }

    public static function getMessageById(PDO $conn, int $messageId)
    {
        $sql = "SELECT * FROM `Message` WHERE `id` = :messageId";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['conversationId'=>$messageId]);

        if($result && $stmt->rowCount() > 0) {
            $record = $stmt->fetch(PDO::FETCH_ASSOC);
            $message = new Message();
            $message->setId($record['id']);
            $message->setConversationId($record['conversationId']);
            $message->setSenderId($record['senderId']);

            return $message;
        }

        return null;
    }

    public function saveMessage(PDO $conn)
    {
        if($this->id === -1) {
            $sql = "INSERT INTO `Message` SET `conversationId` = :conversationId, `senderId`= :senderId";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'conversation'=>$this->conversationId,
                'senderId'=>$this->senderId,
            ]);


            if($result) {
                $this->setId($conn->lastInsertId());
                return true;
            }

        } else {
            $sql = "UPDATE `Message` SET `conversationId` = :conversationId, `senderId`= :senderId WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'conversation'=>$this->conversationId,
                'senderId'=>$this->senderId,
            ]);
            if($result) {
                return true;
            }
        }

        return false;
    }

    public function delete()
    {
        $sql = "DELETE FROM `Message` WHERE id=:id";
        $stmt = self::$conn->prepare($sql);
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
        return $this->conversationId;
    }

    /**
     * @param mixed $conversationId
     */
    public function setConversationId($conversationId): void
    {
        $this->conversationId = $conversationId;
    }

    /**
     * @return mixed
     */
    public function getSenderId()
    {
        return $this->senderId;
    }

    /**
     * @param mixed $senderId
     */
    public function setSenderId($senderId): void
    {
        $this->senderId = $senderId;
    }


}