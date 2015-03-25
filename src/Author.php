<?php

    class Author
    {

    private $author1;
    private $author2;
    private $author3;

    function __construct($author1, $author2, $author3)
    {
        $this->author1 = $author1;
        $this->author2 = $author2;
        $this->author3 = $author3;
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

    //SAVE GET-ALL, DELETE-ALL



    //FIND BY AUTHOR, UPDATE & DELETE AUTHOR

    //funtion getBooks(){}




    }

?>
