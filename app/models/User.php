<?php

class User implements JsonSerializable
{
    protected int $userId;
    protected string $email;
    protected string $firstName;
    protected string $lastName;
    protected string $hashPassword;
    protected int $userType;

    public function jsonSerialize() : mixed
    {
        return [
            'userId' => $this->userId,
            'email' => $this->email,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'hashPassword' => $this->hashPassword,
            'userType' => $this->userType
        ];
    }
    public function getUserId() : int
    {
        return $this->userId;
    }

    public function setUserId(int $id) : void
    {
        $this->userId = $id;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function setEmail(string $email) : void
    {
        $this->email = $email;
    }

    public function getFirstName() : string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName) : void
    {
        $this->firstName = $firstName;
    }

    public function getLastName() : string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName) : void
    {
        $this->lastName = $lastName;
    }


    public function getHashPassword() : string
    {
        return $this->hashPassword;
    }

    public function setHashPassword(string $hash) : void
    {
        $this->hashPassword = $hash;
    }

    public function getUserType() : int
    {
        return $this->userType;
    }

    public function getUserTypeAsString() : string{
        
        switch($this->userType){
            case 1:
                return "Admin";
            case 2:
                return "Employee";
            case 3:
                return "Customer";
            default:
                return "Unknown";
        }
    }

    public function setUserType(int $userType) : void
    {
        $this->userType = $userType;
    }
}

?>