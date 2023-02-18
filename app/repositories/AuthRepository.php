<?php

require_once("Repository.php");

class AuthRepository extends Repository{
    public function storeResetToken($email, $reset_token, $sendTime){
        $stmt = $this->connection->prepare("INSERT INTO reset_tokens (email, reset_token, sendTime) VALUES (:email, :reset_token, :sendTime)");
        $data = [
            ':email' => $email,
            ':reset_token' => $reset_token,
            ':sendTime' => $sendTime
        ];
        $stmt->execute($data);
    }
}
