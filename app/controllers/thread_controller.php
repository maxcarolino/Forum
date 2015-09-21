<?php

class ThreadController extends AppController
{
    CONST PER_PAGE = 3;
    CONST PAGE_DEFAULT = 1;
    CONST PAGE_CREATE = 'create';
    CONST PAGE_CREATE_END = 'create_end';
    CONST PAGE_EDIT = 'edit_thread';
    CONST PAGE_EDIT_END = 'edit_thread_end';
    CONST PAGE_DELETE = 'delete_thread';
    CONST PAGE_DELETE_END = 'delete_thread_end';

    public function index()
    {
        check_user_session();
        $user_id = $_SESSION['user_id'];

        $page = Param::get('page', self::PAGE_DEFAULT);
        $pagination = new SimplePagination($page, self::PER_PAGE);

        $threads = Thread::getAll($pagination->start_index - 1,
                           $pagination->count + 1, $user_id);
        if (isset($_SESSION['sort'])) {
           unset($_SESSION['sort']);
           $threads = Thread::sortTrendsByCategory($pagination->start_index - 1,
                           $pagination->count + 1, $user_id);
        } else {
            $threads = Thread::getAll($pagination->start_index - 1,
                           $pagination->count + 1, $user_id);
        }

        $pagination->checkLastPage($threads);    
      
        $total = Thread::countAll();
        $pages = ceil($total / self::PER_PAGE);
        $trending_threads = Thread::getTrendingThreads();
 
        $this->set(get_defined_vars());
    }

    public function create()
    {
        check_user_session();
        $thread = new Thread();
        $comment = new Comment();
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
                    $thread->create($comment);
                } catch (ValidationException $e) {
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
        $thread_id = get_thread_id_from_url();
        $thread = Thread::get($thread_id);
        $user_id = $_SESSION['user_id'];

        $page = Param::get('page_next', self::PAGE_EDIT);

        if (isThreadOwner($user_id, $thread_id)) {
            switch ($page) {
                case self::PAGE_EDIT:
                    break;
                case self::PAGE_EDIT_END:
                    $thread->title = Param::get('title');
                    $thread->category = Param::get('category');
                    try {
                        $thread->editThread();
                    } catch (ValidationException $e) {
                        $page = self::PAGE_EDIT;
                    }
                    break;
                default:
                    throw new NotFoundException("{$page} is not found");
                    break;
            }
        } 

        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function delete_thread()
    {
        check_user_session();
        $thread_id = get_thread_id_from_url();
        $user_id = $_SESSION['user_id'];
        $thread = Thread::get($thread_id);

        $page = Param::get('page_next', self::PAGE_DELETE);

        if (isThreadOwner($user_id, $thread_id)) {
            switch ($page) {
                case self::PAGE_DELETE:
                    break;
                case self::PAGE_DELETE_END:
                    Comment::deleteAllCommentsInThread($thread_id);
                    $thread->deleteThread();
                    break;
                default:
                    throw new NotFoundException("{$page} is not found");
                    break;
            }
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }
 }