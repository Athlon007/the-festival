<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repositories/Repository.php';

class UserRepository extends Repository
{

    public function getByEmail($email): ?User
    {
        try {
            $query = "SELECT * FROM user WHERE email = :email";
            $stmt = $this->connection->prepare($query);

            $stmt->bindValue(":email", $email);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');

            $result = $stmt->fetch();

            if (is_bool($result))
                return null;
            else
                return $result;
        } catch (PDOException $ex) {
            throw new Exception("PDO Exception: " . $ex->getMessage());
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function insertUser(User $user): void
    {
        try {
            $query = "INSERT INTO user (email, firstName, lastName, hashPassword, userType) VALUES (:email, :firstName, :lastName, :hashPassword, :userType)";
            $stmt = $this->connection->prepare($query);

            $stmt->bindValue(":email", $user->getEmail());
            $stmt->bindValue(":firstName", $user->getFirstName());
            $stmt->bindValue(":lastName", $user->getLastName());
            $stmt->bindValue(":hashPassword", $user->getHash());
            $stmt->bindValue(":userType", $user->getUserType());

            $stmt->execute();
        } catch (PDOException $ex) {
            throw new Exception("PDO Exception: " . $ex->getMessage());
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    // store reset token in database
    public function storeResetToken($email, $reset_token, $sendTime)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO reset_tokens (email, reset_token, sendTime) VALUES (:email, :reset_token, :sendTime)");
            $data = [
                ':email' => $email,
                ':reset_token' => $reset_token,
                ':sendTime' => $sendTime
            ];
            $stmt->execute($data);
        } catch (PDOException $ex) {
            throw new Exception("PDO Exception: " . $ex->getMessage());
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function updatePassword(User $user): void
    {
        try {
            $stmt = $this->connection->prepare("UPDATE user SET hashPassword = :hashPassword WHERE email = :email");
            $data = [
                ':email' => $user->getEmail(),
                ':hashPassword' => $user->getHash()
            ];
            $stmt->execute($data);
        } catch (PDOException $ex) {
            throw new Exception("PDO Exception: " . $ex->getMessage());
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function checkResetToken($email, $reset_token)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM reset_tokens WHERE email = :email AND reset_token = :reset_token AND send_time > DATE_SUB(NOW(), INTERVAL 1 DAY)");
            $data = [
                ':email' => $email,
                ':reset_token' => $reset_token
            ];
            $stmt->execute($data);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (empty($result)) {
                return null;
            } else {
                return $result;
            }
        } catch (PDOException $ex) {
            throw new Exception("PDO Exception: " . $ex->getMessage());
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    // get all users from database
    public function getAllUsers(){
        try {
            $query = "SELECT * FROM user WHERE userType = 3";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');

            $result = $stmt->fetchAll();

            if (is_bool($result))
                return null;
            else
                return $result;
        } catch (PDOException $ex) {
            throw new Exception("PDO Exception: " . $ex->getMessage());
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function deleteUser($id){
        try {
            $stmt = $this->connection->prepare("DELETE FROM user WHERE id = :id");
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        } catch (PDOException $ex) {
            throw new Exception("PDO Exception: " . $ex->getMessage());
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function updateUser(User $user){
        try {
            $stmt = $this->connection->prepare("UPDATE user SET firstName = :firstName, lastName = :lastName, email = :email, userType = :userType WHERE id = :id");
            $data = [
                ':id' => $user->getUserId(),
                ':firstName' => $user->getFirstName(),
                ':lastName' => $user->getLastName(),
                ':email' => $user->getEmail(),
                ':userType' => $user->getUserType()
            ];
            $stmt->execute($data);
        } catch (PDOException $ex) {
            throw new Exception("PDO Exception: " . $ex->getMessage());
        } catch (Exception $ex) {
            throw ($ex);
        }
    }
}