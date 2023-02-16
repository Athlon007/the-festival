<?php
require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../repositories/Repository.php');
require_once(__DIR__ . '/../models/Exceptions/UserNotFoundException.php');

class UserRepository extends Repository{

    public function getbyId($userId) : ?User
    {
        try{
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
        }
        catch(PDOException $ex)
        {
            throw new Exception("PDO Exception: " . $ex->getMessage());
        }
        catch(Exception $ex)
        {
            throw ($ex);
        }        
    }
    
    public function getByEmail($email) : ?User
    {
        try{
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
        }
        catch(PDOException $ex)
        {
            throw new Exception("PDO Exception: " . $ex->getMessage());
        }
        catch(Exception $ex)
        {
            throw ($ex);
        }
    }

    public function insertUser(User $user) : void
    {
        try
        {
            $query = "INSERT INTO users (email, hashPassword, firstName, lastName, userType) VALUES (:email, :hashPassword, :firstName, :lastName, :userType)";
            $stmt = $this->connection->prepare($query);
            
            $stmt->bindValue(":email", $user->getEmail());
            $stmt->bindValue(":firstName", $user->getFirstName());
            $stmt->bindValue(":lastName", $user->getLastName());
            $stmt->bindValue(":hashPassword", $user->getHashPassword());
            $stmt->bindValue(":userType", $user->getUserType());
            
            $stmt->execute();
        }
        catch(PDOException $ex)
        {
            throw new Exception("PDO Exception: " . $ex->getMessage());
        }
        catch(Exception $ex)
        {
            throw ($ex);
        }
    }
}