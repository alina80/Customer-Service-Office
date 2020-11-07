<?php

class User
{
    private $id;
    private $login;
    private $password;
    private $role;

    public function __construct()
    {
        $this->id = -1;
        $this->login = '';
        $this->password = '';
        $this->role = 0;
    }

    public static function getById(PDO $conn, int $id) {
        $sql = "SELECT * FROM `users` WHERE `id` = :id";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['id'=> $id]);

        if($result && $stmt->rowCount() > 0) {
            $record = $stmt->fetch(PDO::FETCH_ASSOC);
            $user = new User();
            $user->setId($record['id']);
            $user->setLogin($record['login']);
            $user->setPassword($record['password']);
            $user->setRole($record['role']);

            return $user;
        }
        return null;
    }

    public static function getByUsername(PDO $conn, string $login) {

        $sql = "SELECT * FROM `users` WHERE `login` = :login";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['login'=>$login]);

        if($result && $stmt->rowCount() > 0) {
            $record = $stmt->fetch(PDO::FETCH_ASSOC);
            $user = new User();
            $user->setId($record['id']);
            $user->setRole($record['role']);
            $user->setLogin($record['login']);
            $user->setPassword($record['password']);

            return $user;
        }
        return null;
    }

    public static function loginUser(PDO $conn, string $login, string $password) {

        $sql = "SELECT * FROM `users` WHERE `login` = :login";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['login'=>$login]);

        if($result && $stmt->rowCount() > 0) {
            $record = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($password,$record['password'])) {
                $user = new User();
                $user->setId($record['id']);
                $user->setRole($record['role']);
                $user->setLogin($record['login']);
                $user->setPassword($record['password']);

                return $user;
            } else {
                return null;
            }
        }

        return null;

    }

    public function save(PDO $conn) {
        if($this->id === -1) {
            echo 'aaa';
            $sql = "INSERT INTO `users` SET `login` = :login, `role` = :role, `password`= :password";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'login'=>$this->login,
                'role'=>$this->role,
                'password'=>$this->password,
            ]);


            if($result) {
                $this->setId($conn->lastInsertId());
                return true;
            }
            else{
                print_r( $stmt->errorInfo());
            }

        } else {
            $sql = "UPDATE `users` SET `login`= :login, `role`=>:role,`password`= :password 
            WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                'login'=>$this->login,
                'role'=>$this->role,
                'password'=>$this->password,
                'id'=>$this->id
            ]);
            if($result) {
                return true;
            }
        }

        return false;
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
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $newHashedPass = password_hash($password, PASSWORD_BCRYPT);

        $this->password = $newHashedPass;
    }

    /**
     * @return int
     */
    public function getRole(): int
    {
        return $this->role;
    }

    /**
     * @param int $role
     */
    public function setRole(int $role): void
    {
        $this->role = $role;
    }


}