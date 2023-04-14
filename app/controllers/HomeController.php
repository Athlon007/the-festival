<?php
require_once(__DIR__ . "/../models/Customer.php");
/**
 * @author: Joshua
 */
class HomeController
{
    const HOME_PAGE = "/../views/home/index.php";
    const CUSTOMER_ACCOUNT_PAGE = "/../views/account/customerAccount.php";
    const EMPLOYEE_ACCOUNT_PAGE = "/../views/account/employeeAccount.php";
    const LOGIN_PAGE = "/../views/account/login.php";
    const REGISTER_PAGE = "/../views/account/register.php";
    
    /**
     * Loads homepage
     */
    public function index(): void
    {
        require(__dir__ . self::HOME_PAGE);
    }
    /**
     * Loads when user presses the account button in nav bar, behaves differently depending on login status
     */
    public function account(): void
    {
        //Load login screen if user is not logged in, else load account management screen
        if (!isset($_SESSION['user'])) {
            require(__dir__ . self::LOGIN_PAGE);
        } else {
            // print type of user object.
            $user = unserialize($_SESSION['user']);

            if ($user->getUserType() == 3) {
                require(__dir__ . self::CUSTOMER_ACCOUNT_PAGE);
            } else {
                require(__dir__ . self::EMPLOYEE_ACCOUNT_PAGE);
            }
        }
    }
    /**
     * Loads register page
     */
    public function register(): void
    {
        require(__dir__ . self::REGISTER_PAGE);
    }
}
