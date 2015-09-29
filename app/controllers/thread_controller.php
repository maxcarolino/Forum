<?php

class ThreadController extends AppController
{
    CONST PER_PAGE = 5;
    CONST PAGE_DEFAULT = 1;
    CONST PAGE_CREATE = 'create';
    CONST PAGE_CREATE_END = 'create_end';
    CONST PAGE_EDIT = 'edit_thread';
    CONST PAGE_EDIT_END = 'edit_thread_end';
    CONST PAGE_DELETE = 'delete_thread';
    CONST PAGE_DELETE_END = 'delete_thread_end';
    CONST PAGE_SEARCH = 'search_thread';
    CONST PAGE_SEARCH_END = 'search_thread_end';

    public function index()
    {
        check_user_session();
        $user_id = $_SESSION['user_id'];

        $page = Param::get('page', self::PAGE_DEFAULT);
        $pagination = new SimplePagination($page, self::PER_PAGE);
        
        $threads = Thread::sortByCategory($pagination->start_index - 1,
                        $pagination->count + 1, $user_id);

        $pagination->checkLastPage($threads);    
      
        $total = Thread::countAll();
        $pages = ceil($total / self::PER_PAGE);
        $trending_threads = Thread::getTrending();
 
        $this->set(get_defined_vars());
    }

    public function create()
    {
        check_user_session();
        $thread = new Thread();
        $comment = new Comment();
        $isFileInvalid = false;
        $page = Param::get('page_next', self::PAGE_CREATE);

        switch ($page) {
            case self::PAGE_CREATE:
                break;
            case self::PAGE_CREATE_END:
                $thread->title = Param::get('title');
                $thread->category = Param::get('category');
                $comment->body = Param::get('body');
                $thread->user_id = $_SESSION['user_id'];
                $comment->user_id = $_SESSION['user_id'];
                try {
                    $comment->filepath = upload();
                    $thread->create($comment);
                } catch (ValidationException $e) {
                    $page = self::PAGE_CREATE;
                } catch (FileTypeException $e) {
                    $isFileInvalid = true;
                    $page = self::PAGE_CREATE;
                }
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function edit_thread()
    {
        check_user_session();
        $user_id = $_SESSION['user_id'];
        $thread = Thread::getOwn(Param::get('thread_id'), $user_id);

        $page = Param::get('page_next', self::PAGE_EDIT);

        if ($thread->is_owner) {
            switch ($page) {
                case self::PAGE_EDIT:
                    break;
                case self::PAGE_EDIT_END:
                    $thread->title = Param::get('title');
                    $thread->category = Param::get('category');
                    try {
                        $thread->edit();
                    } catch (ValidationException $e) {
                        $page = self::PAGE_EDIT;
                    }
                    break;
                default:
                    throw new NotFoundException("{$page} is not found");
                    break;
            }
        } else {
            deny_user();
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function delete_thread()
    {
        check_user_session();
        $user_id = $_SESSION['user_id'];
        $thread_id = Param::get('thread_id');
        $thread = Thread::getOwn(Param::get('thread_id'), $user_id);

        $page = Param::get('page_next', self::PAGE_DELETE);

        if ($thread->is_owner) {
            switch ($page) {
                case self::PAGE_DELETE:
                    break;
                case self::PAGE_DELETE_END:
                    $thread->delete();
                    break;
                default:
                    throw new NotFoundException("{$page} is not found");
                    break;
            }
        } else {
            deny_user();
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function search_thread()
    {
        check_user_session();
        $username = Param::get('username');
        $page = Param::get('page_next', self::PAGE_SEARCH);

        switch ($page) {
            case self::PAGE_SEARCH:
                break;
            case self::PAGE_SEARCH_END:
                $user_id = User::getUserId($username);
                $threads = Thread::getByUser($user_id);
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }
 }