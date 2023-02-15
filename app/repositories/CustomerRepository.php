<?php
require_once(__DIR__ . '/Repository.php');
require_once(__DIR__ . '/../models/Customer.php');
require_once(__DIR__ . '/../models/Exceptions/UserNotFoundException.php');

class CustomerRepository extends Repository{
    
    public function getCustomerById($userId) : Customer
    {
        try{
            $query = "SELECT users.userId, users.email, users.hashPassword, users.firstName, users.lastName, " .
                        "users.userType, customers.dateOfBirth, customers.addressId " . 
                        "FROM users " .
                        "INNER JOIN customers " .
                        "ON users.userId = customers.userId";
            $stmt = $this->connection->prepare($query);
            
            $stmt->bindValue(":userId", $userId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Customer');

            $result = $stmt->fetch();

            if (is_bool($result))
                throw new UserNotFoundException("Customer ID not found");
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
    
    public function insertCustomer(Customer $customer) : void
    {
        try{
            $query = "INSERT INTO users (email, hashPassword, firstName, lastName, userType) " .
                                "VALUES (:email, :hashPassword, :firstName, :lastName, :userType)";
            $stmt = $this->connection->prepare($query);
            
            $stmt->bindValue(":email", $customer->getEmail());
            $stmt->bindValue(":hashPassword", $customer->getHashPassword());
            $stmt->bindValue(":firstName", $customer->getFirstName());
            $stmt->bindValue(":lastName", $customer->getLastName());
            $stmt->bindValue(":userType", $customer->getUserType());
            
            $stmt->execute();
            
            $customer->setUserId($this->connection->lastInsertId());
            
            $query = "INSERT INTO customers ( dateOfBirth, addressId, userId) " .
                        "VALUES (:dateOfBirth, :addressId, :userId)";
            $stmt = $this->connection->prepare($query);
            
            $stmt->bindValue(":userId", $customer->getUserId());
            $stmt->bindValue(":dateOfBirth", $customer->getDateOfBirth());
            
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
?>