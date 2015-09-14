<?php

class UserController extends AppController
{
    CONST PAGE_REGISTER = 'register';
    CONST PAGE_LOG_IN   = 'log_in';
    CONST PAGE_REGISTER_END = 'register_end';
    CONST PAGE_LOG_IN_END   = 'log_in_end';

    public function register()
    {
        $user = new User();
        $page = Param::get('page_next', self::PAGE_REGISTER);
        $user->username = Param::get('username');
        $user->email = Param::get('email');

        switch ($page) {
            case self::PAGE_REGISTER:
                break;
            case self::PAGE_REGISTER_END:
                $user->password = trim(Param::get('password'));
                $user->retype_password = trim(Param::get('retype_password'));
                try {
                    $user->register();
                } catch (ValidationException $e) {
                    $page = self::PAGE_REGISTER;
                } catch (DuplicateEntryException $e) {
                    $user->validation_errors['email']['unique'] = true;
                    $page = self::PAGE_REGISTER;
                }
                break;
            default:
                throw new NotFoundException("{$page} not found");
                break;
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function log_in()
    {
        $user = new User();
        $page = Param::get('page_next', self::PAGE_LOG_IN);

        switch ($page) {
            case self::PAGE_LOG_IN:
                break;
            case self::PAGE_LOG_IN_END:
                $user->username = trim(Param::get('username'));
                $user->password = trim(Param::get('password')); 
                try {
                    $user_account = $user->logInAccount();
                    if ($user_account) {    
                        session_regenerate_id(true);
                        $_SESSION['user_id']  = $user_account->user_id;
                        $_SESSION['username'] = $user_account->username;
                    }    
                } catch (RecordNotFoundException $e) {
                    $page = self::PAGE_LOG_IN;
                }
                break;
            default:
                throw new NotFoundException("{$page} not found");
                break;
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function log_out()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        session_destroy();
        header("Location: ".self::PAGE_LOG_IN);
    }
}