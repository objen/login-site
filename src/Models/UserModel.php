<?php
require_once 'src/Entities/User.php';
class UserModel {

    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
    public function checkUser(string $username): int
    {
        $query = $this->db->prepare
        ('SELECT `id` FROM `users` WHERE `username` = :username');
        $query->execute([
            ':username' => $username
        ]);
        $data = $query->fetch();
            if(isset($data['id']))
            {
                return $data['id'];
            }
    }

    public function checkPassword(int $id, string $EnteredPassword): bool
    {
        $query = $this->db->prepare
        ('SELECT `password` FROM `users` WHERE `id` = :id');
        $query->execute([
            ':id' => $id
        ]);
        $data = $query->fetch();
        if (password_verify($EnteredPassword, $data['password']))
        {
            return true;
        } else
        {
            return false;
        }
    }
    public function checkOldPassword(int $id, string $EnteredPassword): bool
    {
        $query = $this->db->prepare
        ('SELECT `password` FROM `users` WHERE `id` = :id');
        $query->execute([
            ':id' => $id
        ]);
        $data = $query->fetch();
        if ($EnteredPassword === $data['password'])
        {
            return true;
        } else
        {
            return false;
        }
    }
    public function getUserByName(string $username): User
    {
        $query = $this->db->prepare
        ('SELECT * FROM `users` WHERE `username` = :username');
        $query->execute([
            ':username' => $username
        ]);
        $data = $query->fetch();
        return $this->hydrateSingleUser($data);
    }

    public function getUserByID(int $id): User
    {
        $query = $this->db->prepare
        ('SELECT * FROM `users` WHERE `id` = :id');
        $query->execute([
            ':id' => $id
        ]);
        $data = $query->fetch();
        return $this->hydrateSingleUser($data);
    }

    public function createUser(string $username, string $displayname, string $password, ?string $bio, ?string $birthday): void
    {
        $query = $this->db->prepare
        ('INSERT INTO `users` (`username`, `displayname`, `password`, `bio`, `birthday`) VALUES (:username, :displayname, :password, :bio, :birthday)');
        $query->execute([
            ':username' => $username,
            ':displayname' => $displayname,
            ':password' => $password,
            ':bio' => $bio,
            ':birthday' => $birthday
        ]);
    }
    public function updatePassword($id, $password): void
    {
        $query = $this->db->prepare
        ('UPDATE `users` SET `password` = :password WHERE `id` = :id;');
        $query->execute([
            ':password' => $password,
            ':id' => $id
        ]);
    }

    private function hydrateSingleUser(array $data): User
    {
        return new User($data['id'],$data['username'], $data['displayname'], $data['password'], $data['bio'], $data['birthday'], $data['interests']);
    }
}
