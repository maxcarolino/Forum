<?php

class CommentController extends AppController
{
    CONST PER_PAGE = 10;
    CONST PAGE_DEFAULT = 1;
    CONST PAGE_WRITE = 'write';
    CONST PAGE_WRITE_END = 'write_end';
    CONST PAGE_EDIT = 'edit_comment';
    CONST PAGE_EDIT_END = 'edit_comment_end';
    CONST PAGE_DELETE = 'delete_comment';
    CONST PAGE_DELETE_END = 'delete_comment_end';

    public function view() 
    {
        check_user_session();
        $thread = Thread::get(Param::get('thread_id'));
        $thread_id = Param::get('thread_id');
        $_SESSION['thread_id'] = $thread_id;
        $user_id = $_SESSION['user_id'];

        $page = Param::get('page', self::PAGE_DEFAULT);
        $pagination = new SimplePagination($page, self::PER_PAGE);

        $comments = Comment::getAllByThreadId($pagination->start_index - 1,
                              $pagination->count + 1, $thread_id, $user_id);

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
                    $comment->write($thread->id);
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

    public function edit_comment()
    {
        check_user_session();
        $comment = new Comment();
        $comment_id = get_comment_id_from_url();
        
        $comment->id = $comment_id;

        $thread_id = get_thread_id_from_url();
        $thread = Thread::get($thread_id);
        $comment = $comment->get($comment_id);

        $user_id = $_SESSION['user_id'];

        $page = Param::get('page_next', self::PAGE_EDIT);

        if (isCommentOwner($user_id, $comment->id)) {
            switch ($page) {
                case self::PAGE_EDIT:
                    break;
                case self::PAGE_EDIT_END:
                    $comment->body = Param::get('body');
                    try {
                        $comment->edit();
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

    public function delete_comment()
    {
        check_user_session();
        $thread_id = get_thread_id_from_url();
        $thread = Thread::get($thread_id);

        $comment_id = get_comment_id_from_url();

        $user_id = $_SESSION['user_id'];

        $page = Param::get('page_next', self::PAGE_DELETE);

        if (isCommentOwner($user_id, $comment_id)) {
            switch ($page) {
                case self::PAGE_DELETE:
                    break;
                case self::PAGE_DELETE_END:
                    Comment::delete($comment_id);
                    break;
                default:
                    throw new NotFoundException("{$page} is not found");
                    break;
            }
        }
        
        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function set_like()
    {
        check_user_session();
        $comment_id = get_comment_id_from_url();
        $thread_id = get_thread_id_from_url();
        $user_id = $_SESSION['user_id'];

        Likes::setLike($user_id, $comment_id);
        header("location: view?thread_id=$thread_id");
    }

    public function unlike()
    {
        check_user_session();
        $comment_id = get_comment_id_from_url();
        $thread_id = get_thread_id_from_url();
        $user_id = $_SESSION['user_id'];

        Likes::unlike($user_id, $comment_id);
        header("location: view?thread_id=$thread_id");
    }
}