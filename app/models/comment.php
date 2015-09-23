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
        $query = sprintf('SELECT * FROM comment WHERE thread_id = ? ORDER BY
        date DESC LIMIT %d, %d', $offset, $limit);
        $rows = $db->rows($query, array($thread_id));

        foreach ($rows as $row) {
            $row['username'] = User::getUsername($row['user_id']);
            $row['is_owner'] = Comment::isOwner($user_id, $row['id']);
            $row['date'] = date("F j, Y, g:i a", strtotime($row['date']));
            $row['likes'] = Likes::countLike($row['id']);
            $row['is_like'] = Likes::isLike($user_id, $row['id']);
            if ($row['date_modified'] > 0) {
                $row['date_modified'] = date("F j, Y, g:i a", strtotime($row['date_modified']));
            } else {
                $row['date_modified'] = 'None';
            }
            $comments[] = new self($row);
        }

        usort($comments, "cmp"); //sort based on number of likes
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

        $thread_id = $db->rows('SELECT COUNT(*), thread_id FROM comment GROUP BY thread_id ORDER BY COUNT(*) DESC');

        return $thread_id;
    }

    public static function isOwner($user_id, $id)
    {
        $db = DB::conn();

        $row = $db->row('SELECT * FROM comment WHERE user_id = ? AND id = ?',
        array($user_id, $id));

        return (bool) $row;
    }

    public function get($comment_id)
    {
        if (!$this->validate()) {
            throw new ValidationException('Invalid comment');
        }

        $db = DB::conn();

        $row = $db->row('SELECT * FROM comment WHERE id = ?', array($comment_id));

        if (!$row) {
            throw new RecordNotFoundException('No record found!');
        }

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
            'date_modified' => date('Y-m-d H:i:s')
        );

        $db->update('comment', $params, array('id' => $this->id));
    }

    public static function deleteByThreadId($thread_id)
    {
        try {
            $db = DB::conn();
            $db->begin();
            $rows = $db->rows('SELECT id FROM comment WHERE thread_id = ?', array($thread_id));

            foreach ($rows as $row) { //delete all likes in the comment before deleting the comment itself
                Likes::deleteByComment($row['id']);
            }

            $db->query('DELETE FROM comment WHERE thread_id = ?', array($thread_id));
            $db->commit();
        } catch (Exception $e) {
            $db->rollback();
        }
    }

    public static function delete($id)
    {
        try {
            $db = DB::conn();
            $db->begin();

            Likes::deleteByComment($id);
            $db->query('DELETE FROM comment WHERE id = ?', array($id));
            $db->commit();
        } catch (Exception $e) {
            $db->rollback();
        }
    }
}