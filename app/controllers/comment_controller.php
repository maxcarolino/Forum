<?php

class CommentController extends AppController
{
    CONST PER_PAGE = 10;
    CONST PAGE_DEFAULT = 1;
    CONST PAGE_WRITE = 'write';
    CONST PAGE_WRITE_END = 'write_end';

    public function view() 
    {
        check_user_session();
        $thread = Thread::get(Param::get('thread_id'));
        $thread_id = Param::get('thread_id');
        $comment =  new Comment();

        $page = Param::get('page', self::PAGE_DEFAULT);
        $pagination = new SimplePagination($page, self::PER_PAGE);
      
        $comments = Comment::getAllByThreadId($pagination->start_index - 1,
                              $pagination->count + 1, $thread_id);

        $pagination->checkLastPage($comments);
      
        $total = Comment::count($thread_id);
        $pages = ceil($total / self::PER_PAGE);

        $this->set(get_defined_vars());
    }
  
    public function write()
    {        
        check_user_session();
        $thread = Thread::get(Param::get('thread_id'));
        $comment = new Comment();
        $page = Param::get('page_next');

        switch ($page) {
            case self::PAGE_WRITE:
                break;
            case self::PAGE_WRITE_END:
                $comment->body = Param::get('body');
                $comment->user_id = $_SESSION['user_id'];
                try {
                    $comment->write($comment, $thread->id);
                } catch (ValidationException $e) {
                    $page = self::PAGE_WRITE;
                }
                break;
            default:
                throw new NotFoundException("{$page} is not found!");
                break;
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }
}