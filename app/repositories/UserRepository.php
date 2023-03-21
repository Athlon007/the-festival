<?php
require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../repositories/Repository.php');
require_once(__DIR__ . '/../models/Exceptions/UserNotFoundException.php');

class UserRepository extends Repository
{
    public function getbyId($userId): User
    {
        try {
            $query = "SELECT * FROM users WHERE userId = :userId";
            $stmt = $this->connection->prepare($query);

            $stmt->bindValue(":userId", $userId);
            $stmt->execute();

            $result = $stmt->fetch();

            if (is_bool($result))
                throw new UserNotFoundException("User ID not found");

            return $this->buildUser($result);
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

            $result = $stmt->fetch();

            if (is_bool($result))
                throw new UserNotFoundException("User email not found");

            return $this->buildUser($result);
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function insertUser(User $user): void
    {
        try {
            $query = "INSERT INTO users (email, firstName, lastName, hashPassword, userType, registrationDate) VALUES (:email, :firstName, :lastName, :hashPassword, :userType, NOW())";
            $stmt = $this->connection->prepare($query);

            $stmt->bindValue(":email", $user->getEmail());
            $stmt->bindValue(":firstName", $user->getFirstName());
            $stmt->bindValue(":lastName", $user->getLastName());
            $stmt->bindValue(":hashPassword", $user->getHashPassword());
            $stmt->bindValue(":userType", $user->getUserType());

            $stmt->execute();
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
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function verifyResetToken($email, $reset_token)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM resettokens WHERE email =:email AND reset_token =:reset_token AND sendTime >= DATE_SUB(NOW(), INTERVAL 1 DAY)");
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
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    // get all users from database
    public function getAllUsers(): array
    {
        try {
            $query = "SELECT * FROM users";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();

            $result = $stmt->fetchAll();

            if (is_bool($result))
                throw new UserNotFoundException("User ID not found");

            $users = array();

            foreach ($result as $row) {
                $user = $this->buildUser($row);
                $users[] = $user;
            }

            return $users;
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    private function buildUser($row): User
    {
        $user = new User();
        $user->setUserId($row['userId']);
        $user->setEmail($row['email']);
        $user->setFirstName($row['firstName']);
        $user->setLastName($row['lastName']);
        $user->setHashPassword($row['hashPassword']);
        $user->setUserType($row['userType']);
        $user->setRegistrationDate(new DateTime($row['registrationDate']));

        return $user;
    }

    // add new user or admin to database
    public function addUser(User $user)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO users (email, firstName, lastName, hashPassword, userType, registrationDate) VALUES (:email, :firstName, :lastName, :hashPassword, :userType, NOW())");
            $data = [
                ':email' => $user->getEmail(),
                ':firstName' => $user->getFirstName(),
                ':lastName' => $user->getLastName(),
                ':hashPassword' => $user->getHashPassword(),
                ':userType' => $user->getUserType()
            ];
            $stmt->execute($data);
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
        
            $result = $stmt->fetch();

            if (is_bool($result))
                return null;
            else
                return $result;
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function updateUser(User $user)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE users SET firstName = :firstName, lastName = :lastName, email = :email, userType = :userType WHERE userId = :id");
            $data = [
                ':id' => $user->getUserId(),
                ':firstName' => $user->getFirstName(),
                ':lastName' => $user->getLastName(),
                ':email' => $user->getEmail(),
                ':userType' => $user->getUserType()
            ];
            $stmt->execute($data);
        } catch (Exception $ex) {
            throw ($ex);
        }
    }

    public function emailAlreadyExists($email)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (empty($result)) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $ex) {
            throw ($ex);
        }
    }
}