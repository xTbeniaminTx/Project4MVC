<?php

class Comment
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getComments()
    {
        $this->db->query("SELECT * FROM comments ORDER BY comment_id DESC");

        $results = $this->db->resultSet();

        return $results;

    }

    public function addComment($data)
    {
        $this->db->query('INSERT INTO 
comments (comment_chapter_id, comment_author, comment_email, comment_content,comment_status, comment_date)
                              VALUES
(:comment_chapter_id, :comment_author, :comment_email, :comment_content, :comment_status, :comment_date)');
        $this->db->bind(':comment_chapter_id', $data['comment_chapter_id']);
        $this->db->bind(':comment_author', $data['comment_author']);
        $this->db->bind(':comment_email', $data['comment_email']);
        $this->db->bind(':comment_content', $data['comment_content']);
        $this->db->bind(':comment_status', $data['comment_status']);
        $this->db->bind(':comment_date', $data['comment_date']);

        //execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateChapter($data)
    {
        $this->db->query('UPDATE chapters SET title = :title, content = :content WHERE id=:id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':content', $data['content']);

        //execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getCommentById($id)
    {
        $this->db->query('SELECT * FROM comments WHERE comment_chapter_id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;

    }

    public function deleteChapter($id)
    {
        $this->db->query('DELETE FROM chapters WHERE id = :id');
        $this->db->bind(':id', $id);

        //execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

}