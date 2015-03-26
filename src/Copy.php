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

    // function addBook($book)
    // {
    //     $GLOBALS['DB']->exec("INSERT INTO authors_books (author_id, book_id) VALUES ({$this->getId()}, {$book->getId()});");
    // }
    //
    // function getBooks(){
    //     $query = $GLOBALS['DB']->query("SELECT books.* FROM authors JOIN authors_books ON (authors.id = authors_books.author_id) JOIN books ON (authors_books.book_id = books.id) WHERE authors.id = {$this->getId()};");
    //
    //     $returned_books = $query->fetchAll(PDO::FETCH_ASSOC);
    //
    //     $books = array();
    //     foreach($returned_books as $r_book){
    //         $title = $r_book['title'];
    //         $genre = $r_book['genre'];
    //         $id = $r_book['id'];
    //         $new_book = new Book($title, $genre, $id);
    //         array_push($books, $new_book);
    //     }
    //     return $books;
    // }




    }

?>
