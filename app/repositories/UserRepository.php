<?php
require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../repositories/Repository.php');
require_once(__DIR__ . '/../models/Exceptions/UserNotFoundException.php');

class UserRepository extends Repository
{
    public function getbyId($userId): ?User
    {
        try {
            $query = "SELECT * FROM users WHERE userId = :userId";
            $stmt = $this->connection->prepare($query);

            $stmt->bindValue(":userId", $userId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');

            $result = $stmt->fetch();

            if (is_bool($result))
                throw new UserNotFoundException("User ID not found");
            else
                return $result;
        } catch (PDOException $ex) {
            throw new Exception("PDO Exception: " . $ex->getMessage());
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function getByEmail($email): ?User
    {
        try {
            $query = "SELECT * FROM users WHERE email = :email";
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
            $stmt->bindValue(":hashPassword", $user->getHashPassword());
            $stmt->bindValue(":userType", $user->getUserType());

            $stmt->execute();
        } catch (PDOException $ex) {
            throw new Exception("PDO Exception: " . $ex->getMessage());
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    // store reset token in database
    public function storeResetToken($email, $reset_token)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO resettokens (email, reset_token, sendTime) VALUES (:email, :reset_token, NOW())");
            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":reset_token", $reset_token);
            $stmt->execute();
        } catch (PDOException $ex) {
            throw new Exception("PDO Exception: " . $ex->getMessage());
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function updatePassword(User $user): void
    {
        try {
            $stmt = $this->connection->prepare("UPDATE users SET hashPassword = :hashPassword WHERE email = :email");
            $data = [
                ':email' => $user->getEmail(),
                ':hashPassword' => $user->getHashPassword()
            ];
            $stmt->execute($data);
        } catch (PDOException $ex) {
            throw new Exception("PDO Exception: " . $ex->getMessage());
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function verifyResetToken($email, $reset_token)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM resettokens WHERE email =:email AND reset_token =:reset_token AND sendTime > DATE_SUB(NOW(), INTERVAL 1 DAY)");
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
    public function getAllUsers()
    {
        try {
            $query = "SELECT * FROM users WHERE userType = 3";
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

    public function deleteUser($id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM users WHERE userId = :id");
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        } catch (PDOException $ex) {
            throw new Exception("PDO Exception: " . $ex->getMessage());
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function getUserByID($id)
    {
        try {
            $query = "SELECT * FROM users WHERE userId = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(':id', $id);
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

    public function updateUser(User $user)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE users SET firstName = :firstName, lastName = :lastName, email = :email WHERE userId = :id");
            $data = [
                ':id' => $user->getUserId(),
                ':firstName' => $user->getFirstName(),
                ':lastName' => $user->getLastName(),
                ':email' => $user->getEmail()
            ];
            $stmt->execute($data);
        } catch (PDOException $ex) {
            throw new Exception("PDO Exception: " . $ex->getMessage());
        } catch (Exception $ex) {
            throw ($ex);
        }
    }
}