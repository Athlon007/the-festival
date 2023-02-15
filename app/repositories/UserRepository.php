<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repositories/Repository.php';

class UserRepository extends Repository{

    public function getByEmail($email) : ?User
    {
        try{
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
            $query = "INSERT INTO user (email, firstName, lastName, hashPassword, userType) VALUES (:email, :firstName, :lastName, :hashPassword, :userType)";
            $stmt = $this->connection->prepare($query);
            
            $stmt->bindValue(":email", $user->getEmail());
            $stmt->bindValue(":firstName", $user->getFirstName());
            $stmt->bindValue(":lastName", $user->getLastName());
            $stmt->bindValue(":hashPassword", $user->getHash());
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