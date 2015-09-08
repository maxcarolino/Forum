<?php

class CommentController extends AppController
{
    CONST PER_PAGE = 10;
    CONST PAGE_DEFAULT = 1;

    public function view() 
    {
        $thread = Thread::get(Param::get('thread_id'));
        $thread_id = Param::get('thread_id');
        $comment =  new Comment();

        $page = Param::get('page', self::PAGE_DEFAULT);
        $pagination = new SimplePagination($page, self::PER_PAGE);
      
        $comments = $comment->get_comments($pagination->start_index - 1, $pagination->count + 1, $thread_id);
        $pagination->checkLastPage($comments);
      
        $total = Comment::count($thread_id);
        $pages = ceil($total / self::PER_PAGE);

        $this->set(get_defined_vars());
    }
  
    public function write()
    {
        $thread = Thread::get(Param::get('thread_id'));
        $comment = new Comment();
        $page = Param::get('page_next');

        switch ($page) {
            case 'write':
                break;
            case 'write_end':
                $comment->body = Param::get('body');
                $comment->user_id = $_SESSION['user_id'];
                try {
                    $comment->write($comment, $thread->id, $comment->user_id, $comment->body);
                } catch (ValidationException $e) {
                    $page = 'write';
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