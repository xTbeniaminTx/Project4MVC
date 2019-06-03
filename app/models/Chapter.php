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
        $this->db->query('SELECT * FROM chapters');

        $results = $this->db->resultSet();

        return $results;

    }

}