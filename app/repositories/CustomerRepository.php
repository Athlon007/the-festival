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
            $query = "INSERT INTO customers ( dateOfBirth, addressId, userId) " .
                        "VALUES (:dateOfBirth, :addressId, :userId)";
            $stmt = $this->connection->prepare($query);
            
            $stmt->bindValue(":dateOfBirth", $customer->getDateOfBirth());
            $stmt->bindValue(":addressId", $customer->getAddress()->getAddressId());
            $stmt->bindValue(":userId", $customer->getUserId());
            
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