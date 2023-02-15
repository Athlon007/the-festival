<?php
require_once(__DIR__ . '/Repository.php');
require_once(__DIR__ . '/../models/Customer.php');
require_once(__DIR__ . '/../models/Exceptions/UserNotFoundException.php');

class CustomerRepository extends Repository{
    
    public function getCustomerById($userId) : Customer
    {
        try{
            $query = "select users.userId, users.email, users.hashPassword, users.firstName, users.lastName, " .
                        "users.userType, customers.dateOfBirth, customers.addressId " . 
                        "from users " .
                        "inner join customers " .
                        "on users.userId = customers.userId";
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
}
?>