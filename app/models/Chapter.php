<?php

class Chapter
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getChapters()
    {
        $this->db->query("SELECT * FROM chapters ORDER BY id DESC");

        $results = $this->db->resultSet();

        return $results;

    }

    public function addChapter($data)
    {
        $this->db->query('INSERT INTO chapters (id, title, content)
                              VALUES(:id, :title, :content)');
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

    public function getChaptersById($id) {
        $this->db->query('SELECT * FROM chapters WHERE id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;

    }

}