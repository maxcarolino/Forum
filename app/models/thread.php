<?php

class Thread extends AppModel
{

   public $validation = array (
      'title'         => array (
	  'length'    => array ('validate_between', 1, 30,),
      ),
   );

   public static function get($id)
   {
      $db = DB::conn();

      $row = $db->row('SELECT * FROM thread WHERE id = ?', 
      array($id)
      );

      if(!$row) {
	 throw new RecordNotFoundException('No record found!');
      }

      return new self($row);
   }
	
   public static function getAll($offset, $limit)
   {
      $threads = array();
      $db = DB::conn();
      $rows = $db->rows("SELECT * FROM thread LIMIT {$offset}, {$limit}");

      foreach ($rows as $row) {
	 $threads[] = new Thread($row);
      }

      return $threads;
   }
  
   public static function countAll()
   {
      $db = DB::conn();
      return (int) $db->value('SELECT COUNT(*) FROM thread');
   }

   public function create(Comment $comment, $comment_user_id, $comment_body)
   {
      $this->validate();
      $comment->validate();

      if($this->hasError() || $comment->hasError()) {
	 throw new ValidationException('Invalid thread or comment.');
      }

      $db = DB::conn();
      $db->begin();

      $db->query('INSERT INTO thread SET title = ?, created = NOW()',
      array($this->title)
      );

      $this->id = $db->lastInsertId();

      //write the first comment
      $comment->write($comment, $this->id, $comment_user_id, $comment_body);

      $db->commit();
   }
}
