<?php

    class Author
    {

    private $author1;
    private $author2;
    private $author3;
    private $id;

    function __construct($author1, $author2, $author3, $id)
    {
        $this->author1 = $author1;
        $this->author2 = $author2;
        $this->author3 = $author3;
        $this->id = $id;
    }

    //SET GET PROPS
    function setAuthor1($new_author1)
    {
        $this->author1 = (string) $new_author1;
    }

    function getAuthor1()
    {
        return $this->author1;
    }

    function setAuthor2($new_author1)
    {
        $this->author2 = (string) $new_author1;
    }

    function getAuthor2()
    {
        return $this->author2;
    }

    function setAuthor3($new_author3)
    {
        $this->author3 = (string) $new_author3;
    }

    function getAuthor3()
    {
        return $this->author3;
    }

    function setId($new_id)
    {
        $this->id = (int) $new_id;
    }
    function getId()
    {
        return $this->id;
    }

    //SAVE GET-ALL, DELETE-ALL
    function save()
    {
        $statement = $GLOBALS['DB']->query("INSERT INTO authors (author1, author2, author3) VALUES ('{$this->getAuthor1()}', '{$this->getAuthor2()}', '{$this->getAuthor3()}') RETURNING id;");
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $this->setId($result['id']);
    }

    static function getAll()
    {
        $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors;");
        $authors = array();
        foreach ($returned_authors as $author){
            $author1 = $author['author1'];
            $author2 = $author['author2'];
            $author3 = $author['author3'];
            $id = $author['id'];
            $new_author = new Author($author1, $author2, $author3, $id);
            array_push($authors, $new_author);
        }
        return $authors;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM authors *;");
    }


    //FIND BY AUTHOR, UPDATE & DELETE AUTHOR

        static function find($search_id)
        {
            $found_author = null;
            $authors = Author::getAll();
            foreach($authors as $author){
                $author_id = $author->getId();
                if($author_id == $search_id){
                    $found_author = $author;
                }
            }
            return $found_author;
        }

        function update($new_author1, $new_author2, $new_author3)
        {
            $GLOBALS['DB']->exec("UPDATE authors SET author1 = '{$new_author1}' WHERE id = {$this->getId()};");
            $this->setAuthor1($new_author1);
            $GLOBALS['DB']->exec("UPDATE authors SET author2 = '{$new_author2}' WHERE id = {$this->getId()};");
            $this->setAuthor2($new_author2);
            $GLOBALS['DB']->exec("UPDATE authors SET author3 = '{$new_author3}' WHERE id = {$this->getId()};");
            $this->setAuthor3($new_author3);
        }


    //funtion getBooks(){}




    }

?>
