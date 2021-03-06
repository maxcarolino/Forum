<?php

class UserController extends AppController
{
    CONST PAGE_REGISTER = 'register';
    CONST PAGE_LOG_IN   = 'user/log_in';
    CONST PAGE_REGISTER_END = 'register_end';
    CONST PAGE_LOG_IN_END   = 'log_in_end';
    CONST PAGE_EDIT_PROFILE = 'edit_profile';
    CONST PAGE_EDIT_PROFILE_END = 'profile_end';
    CONST PAGE_EDIT_PASSWORD_END = 'password_end';
    CONST PAGE_PROFILE_NOT_FOUND = 'profile_not_found';

    public function register()
    {
        $user = new User();
        $page = Param::get('page_next', self::PAGE_REGISTER);
        $user->username = trim(Param::get('username'));
        $user->email = trim(Param::get('email'));
        $user->firstname = trim(Param::get('firstname'));
        $user->lastname = trim(Param::get('lastname'));
        $user->department = trim(Param::get('department'));

        if (isset($_SESSION['username'])) {
            redirect_to(url(THREAD_LIST));
        }

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

        if (isset($_SESSION['username'])) {
            redirect_to(url(THREAD_LIST));
        }

        switch ($page) {
            case self::PAGE_LOG_IN:
                break;
            case self::PAGE_LOG_IN_END:
                $user->username = trim(Param::get('username'));
                $user->password = trim(Param::get('password'));

                try {
                    $user_account = $user->logInAccount();
                    if ($user_account AND !(isset($_SESSION['username']))) {
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

    public function profile()
    {
        check_user_session();
        $user_id = $_SESSION['user_id'];

        try {
            $user_account = User::getProfile($user_id);
            $bookmark = Bookmarks::getAllbyUser($user_id);
        } catch (RecordNotFoundException $e) {
            $this->render(self::PAGE_PROFILE_NOT_FOUND);
        }
        
        $this->set(get_defined_vars());
    }

    public function other_user_profile()
    {
        check_user_session();
        $user_id = Param::get('user_id');

        try {
            $user_account = User::getProfile($user_id);
            $bookmark = Bookmarks::getAllbyUser($user_id);
        } catch (RecordNotFoundException $e) {
            $this->render(self::PAGE_PROFILE_NOT_FOUND);
        }
        
        $this->set(get_defined_vars());
    }

    public function edit_profile()
    {
        check_user_session();
        $page = Param::get('page_next',self::PAGE_EDIT_PROFILE);
        $user_id = $_SESSION['user_id'];
        $isFileInvalid = false;
        $user_account = User::getProfile($user_id);

        switch ($page) {
            case self::PAGE_EDIT_PROFILE:
                break;
            case self::PAGE_EDIT_PROFILE_END:
                $user_account->id = $user_id;
                $user_account->username = trim(Param::get('username'));
                $user_account->email = trim(Param::get('email'));
                $user_account->firstname = trim(Param::get('firstname'));
                $user_account->lastname = trim(Param::get('lastname'));
                $user_account->department = trim(Param::get('department'));
                try {
                    $user_account->profile_pic =  upload_profile_pic();
                    $user_account->updateProfile();
                } catch (ValidationException $e) {
                    $page = self::PAGE_EDIT_PROFILE;
                } catch (DuplicateEntryException $e) {
                    $user_account->validation_errors['email']['unique'] = true;
                    $page = self::PAGE_EDIT_PROFILE;
                } catch (FileTypeException $e) {
                    $isFileInvalid = true;
                    $page = self::PAGE_EDIT_PROFILE;
                }
                break;
            case self::PAGE_EDIT_PASSWORD_END:
                $user_account->password = trim(Param::get('password'));
                $user_account->retype_password = trim(Param::get('retype_password'));
                try {
                    $user_account->updatePassword();
                } catch (ValidationException $e) {
                    $page = self::PAGE_EDIT_PROFILE;
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
        redirect_to(url(self::PAGE_LOG_IN));
    }
}