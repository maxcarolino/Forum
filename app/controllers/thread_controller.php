<?php

class ThreadController extends AppController
{
   const PER_PAGE = 12;

   public function index()
   {
      session_start();
      $page = Param::get('page', 1);
      $pagination = new SimplePagination($page, self::PER_PAGE);

      $threads = Thread::get_all($pagination->start_index - 1, $pagination->count + 1); 
      $pagination->checkLastPage($threads);    
      
      $total = Thread::count_all();
      $pages = ceil($total / self::PER_PAGE);
 
      $this->set(get_defined_vars());
   }

   public function create()
   {
      session_start();
      $thread = new Thread();
      $comment = new Comment();
      $page = Param::get('page_next', 'create');

      switch ($page) {
      case 'create':
         break;
      case 'create_end':
	 $thread->title = Param::get('title');
	 $comment->body = Param::get('body');
         $comment->user_id = $_SESSION['user_id'];
	 try {
	    $thread->create($comment, $comment->user_id, $comment->body);
	 } catch (ValidationException $e) {
	    $page = 'create';
	 }
	 break;
      default:
	 throw new NotFoundException("{$page} is not found");
	 break;
      }

      $this->set(get_defined_vars());
      $this->render($page);
   }
}
