<?php

class CommentController extends AppController
{
   public function view() 
   {
      session_start();
      $thread = Thread::get(Param::get('thread_id'));
      $thread_id = Param::get('thread_id');
      $comment =  new Comment;

      $page = Param::get('page', 1);
      $per_page = 10;
      $pagination = new SimplePagination($page, $per_page);
      
      $comments = $comment->getComments($pagination->start_index - 1, $pagination->count + 1, $thread_id);
      $pagination->checkLastPage($comments);
      
      $total = Comment::countComments($thread_id);
      $pages = ceil($total / $per_page);

      $this->set(get_defined_vars());
   }
  
   public function write()
   {
      session_start();
      $thread = Thread::get(Param::get('thread_id'));
      $comment = new Comment;
      $page = Param::get('page_next');

      switch ($page) {
      case 'write':
	 break;
      case 'write_end':
         $comment->username = Param::get('username');
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

