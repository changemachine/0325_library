<?php

    class Copy
    {

    private $book_id;
    private $id;

    function __construct($book_id, $id)
    {
        $this->book_id = $book_id;
        $this->id = $id;
    }

    //SET GET PROPS
    function setBookId($new_book_id)
    {
        $this->book_id = (int) $new_book_id;
    }

    function getBookId()
    {
        return $this->book_id;
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
        $statement = $GLOBALS['DB']->query("INSERT INTO copies (book_id) VALUES ({$this->getBookId()}) RETURNING id;");
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $this->setId($result['id']);
    }

    static function getAll()
    {
        $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies;");
        $copies = array();
        foreach ($returned_copies as $copy){
            $book_id = $copy['book_id'];
            $id = $copy['id'];
            $new_copy = new Copy($book_id, $id);
            array_push($copies, $new_copy);
        }
        return $copies;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM copies *;");
    }


    // √ FIND BY COPY, UPDATE & DELETE COPY

    static function find($search_id)
    {
        $found_copy = null;
        $copies = Copy::getAll();
        foreach($copies as $copy){
            $copy_id = $copy->getId();
            if($copy_id == $search_id){
                $found_copy = $copy;
            }
        }
        return $found_copy;
    }

    function updateCopy($new_book_id)
    {
        $GLOBALS['DB']->exec("UPDATE copies SET book_id = {$new_book_id} WHERE id = {$this->getId()};");
        $this->setBookId($new_book_id);
    }

    function deleteCopy()
    {
        $GLOBALS['DB']->exec("DELETE FROM copies WHERE id = {$this->getId()};");

    }

    function addCheckout($patron, $duedate)
    {
        $GLOBALS['DB']->exec("INSERT INTO checkouts (patron_id, copy_id, duedate) VALUES ({$patron->getId()}, {$this->getId()}, '{$duedate}');");
    }







    }

?>
