<?php
class Comment extends AppModel
{
   public $validation =  array (
      'body'          => array (
	    'length'  => array ('validate_between', 1, 200,)
      )
   );

   public static function countComments($thread_id)
   {
      $db = DB::conn();
      return (int) $db->value('SELECT COUNT(*) FROM comment WHERE thread_id = ?', array($thread_id));
   }

   public function getComments($offset, $limit, $thread_id)
   {
      $comments = array();
      $db = DB::conn();

      $rows = $db->rows("SELECT *, user.username FROM comment INNER JOIN user ON comment.user_id=user.user_id WHERE thread_id = ? ORDER BY created ASC LIMIT {$offset}, {$limit}",
      array($thread_id)
      );

      foreach ($rows as $row) {
         $comments[] = new Comment($row);
      }

      return $comments;
   }
  
   public function write(Comment $comment, $thread_id, $user_id, $body)
   {
      if(!$comment->validate()) {
	 throw new ValidationException('Invalid comment');
      }
      $db = DB::conn();
      $db->query('INSERT INTO comment SET thread_id = ?, user_id = ?, body = ?, created = NOW()',
      array($thread_id, $user_id, $body)
      );
   }
}
