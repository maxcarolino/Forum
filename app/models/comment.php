<?php

class Comment extends AppModel
{
    CONST MIN_LENGTH = 1;
    CONST MAX_LENGTH = 255;

    public $validation  =  array (
        'body'          => array (
            'length'    => array ('validate_between',
                                  self::MIN_LENGTH, self::MAX_LENGTH,)
        )
    );

    public static function count($thread_id)
    {
        $db = DB::conn();
        return $db->value('SELECT COUNT(*) FROM comment WHERE thread_id = ?',
        array($thread_id));
    }

    public static function getAllByThreadId($offset, $limit, $thread_id, $user_id)
    {
        $comments = array();
        $db = DB::conn();
        $query = sprintf('SELECT * FROM comment WHERE thread_id = ?');
        $rows = $db->rows($query, array($thread_id)); 

        foreach ($rows as $row) {
            $row['username'] = User::getUsername($row['user_id']);
            $row['profile_pic'] = User::getProfilePic($row['user_id']);
            $row['is_owner'] = Comment::isOwner($user_id, $row['id']);
            $row['date'] = date("F j, Y, g:i a", strtotime($row['date']));
            $row['likes'] = Likes::count($row['id']);
            $row['is_like'] = Likes::isLike($user_id, $row['id']);
            if ($row['date_modified'] > 0) {
                $row['date_modified'] = date("F j, Y, g:i a", strtotime($row['date_modified']));
            } else {
                $row['date_modified'] = 'None';
            }
            $comments[] = new self($row);
        }

        usort($comments, "compare"); //sort based on number of likes
        $comments = array_slice($comments, $offset, $limit); //paginate the comments
        return $comments;
    }
  
    public function write($thread_id)
    {
        if (!$this->validate()) {
            throw new ValidationException('Invalid comment');
        }
        $db = DB::conn();

        $params = array(
            'thread_id' => $thread_id,
            'user_id'   => $this->user_id,
            'body'      => $this->body,
            'filepath'  => $this->filepath,
        );

        $db->insert('comment', $params);
    }

    public static function sortMostComments()
    {
        $db = DB::conn();

        $trending_threads = $db->rows('SELECT COUNT(*), thread_id FROM comment GROUP BY thread_id ORDER BY COUNT(*) DESC, date DESC LIMIT 10');

        return $trending_threads;
    }

    public static function isOwner($user_id, $id)
    {
        $db = DB::conn();

        $row = $db->row('SELECT * FROM comment WHERE user_id = ? AND id = ?',
        array($user_id, $id));

        return (bool) $row;
    }

    public static function getOwn($comment_id, $user_id) //retrieve owned comments
    {
        
        $db = DB::conn();
        $row = $db->row('SELECT * FROM comment WHERE id = ?', array($comment_id));

        if (!$row) {
            throw new RecordNotFoundException('No record found!');
        }
        
        $row['is_owner'] = self::isOwner($user_id, $comment_id);
        return new self($row);
    }

    public function edit()
    {
        if (!$this->validate()) {
            throw new ValidationException('Invalid Comment');
        }

        $db = DB::conn();

        $params = array(
            'body' => $this->body,
            'date_modified' => date('Y-m-d H:i:s'),
            'filepath' => $this->filepath,
        );

        $db->update('comment', $params, array('id' => $this->id));
    }

    public static function deleteByThreadId($thread_id)
    {
        try {
            $db = DB::conn();
            $db->begin();
            $rows = $db->rows('SELECT id, filepath FROM comment WHERE thread_id = ?', array($thread_id));

            foreach ($rows as $row) { //delete all likes in the comment before deleting the comment itself
                if (!is_null($row['filepath'])) {
                    unlink($row['filepath']); //delete the image in a comment
                }
                Likes::deleteByComment($row['id']);
            }

            $db->query('DELETE FROM comment WHERE thread_id = ?', array($thread_id));
            $db->commit();
        } catch (Exception $e) {
            $db->rollback();
        }
    }

    public function delete()
    {
        try {
            $db = DB::conn();
            $db->begin();

            Likes::deleteByComment($this->id);
            $db->query('DELETE FROM comment WHERE id = ?', array($this->id));
            $db->commit();
        } catch (Exception $e) {
            $db->rollback();
        }
    }
}