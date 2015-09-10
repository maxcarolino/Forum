<?php

class ThreadController extends AppController
{
    CONST PER_PAGE = 12;
    CONST PAGE_DEFAULT = 1;
    CONST PAGE_CREATE = 'create';
    CONST PAGE_CREATE_END = 'create_end';

    public function index()
    {
        if (isset($_SESSION['username'])) {
            $page = Param::get('page', self::PAGE_DEFAULT);
            $pagination = new SimplePagination($page, self::PER_PAGE);

            $threads = Thread::getAll($pagination->start_index - 1,
                               $pagination->count + 1); 
            $pagination->checkLastPage($threads);    
          
            $total = Thread::countAll();
            $pages = ceil($total / self::PER_PAGE);
     
            $this->set(get_defined_vars());
        } else {
            redirect();
        }
    }

    public function create()
    {
        if (isset($_SESSION['username'])) {
            $thread = new Thread();
            $comment = new Comment();
            $page = Param::get('page_next', self::PAGE_CREATE);

            switch ($page) {
                case self::PAGE_CREATE:
                    break;
                case self::PAGE_CREATE_END:
                    $thread->title = Param::get('title');
                    $comment->body = Param::get('body');
                    $comment->user_id = $_SESSION['user_id'];
                    try {
                        $thread->create($comment, $comment->user_id, $comment->body);
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
        } else {
            redirect();
        }
    }
}