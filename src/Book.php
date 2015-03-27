<?php

    class Book
    {

    private $title;
    private $genre;
    private $id;

    function __construct($title, $genre, $id)
    {
        $this->title = $title;
        $this->genre = $genre;
        $this->id = $id;
    }

    //SET GET PROPS
    function setTitle($new_title)
    {
        $this->title = (string) $new_title;
    }

    function getTitle()
    {
        return $this->title;
    }

    function setGenre($new_genre)
    {
        $this->genre = (string) $new_genre;
    }

    function getGenre()
    {
        return $this->genre;
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
        $statement = $GLOBALS['DB']->query("INSERT INTO books (title, genre) VALUES ('{$this->getTitle()}', '{$this->getGenre()}') RETURNING id;");
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $this->setId($result['id']);
    }

    static function getAll()
    {
        $returned_books = $GLOBALS['DB']->query("SELECT * FROM books;");
        $books = array();
        foreach ($returned_books as $book){
            $title = $book['title'];
            $genre = $book['genre'];
            $id = $book['id'];
            $new_book = new Book($title, $genre, $id);
            array_push($books, $new_book);
        }
        return $books;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM books *;");
    }


    // √ FIND BY AUTHOR, UPDATE & DELETE AUTHOR

        static function find($search_id)
        {
            $found_book = null;
            $books = Book::getAll();
            foreach($books as $book){
                $book_id = $book->getId();
                if($book_id == $search_id){
                    $found_book = $book;
                }
            }
            return $found_book;
        }

        function update($new_title, $new_genre)
        {
            $GLOBALS['DB']->exec("UPDATE books SET title = '{$new_title}' WHERE id = {$this->getId()};");
            $this->setTitle($new_title);
            $GLOBALS['DB']->exec("UPDATE books SET genre = '{$new_genre}' WHERE id = {$this->getId()};");
            $this->setGenre($new_genre);
        }

        function deleteBook()
        {
            $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
            // JOIN TABLE!
        }


        function addAuthor($author)
        {
            $GLOBALS['DB']->exec("INSERT INTO authors_books (author_id, book_id) VALUES ({$author->getId()}, {$this->getId()});");
        }

        function getAuthors()
        {
            $query = $GLOBALS['DB']->query("SELECT authors.* FROM books JOIN authors_books ON (books.id = authors_books.book_id) JOIN authors ON (authors_books.author_id = authors.id) WHERE books.id = {$this->getId()};");

            $returned_authors = $query->fetchAll(PDO::FETCH_ASSOC);

            $authors = array();
            foreach($returned_authors as $r_author){
                $author = $r_author['author'];
                $id = $r_author['id'];
                $new_author = new Author($author, $id);
                array_push($authors, $new_author);
            }
            return $authors;
        }

        function addCopy()
        {
            $GLOBALS['DB']->exec("INSERT INTO copies (book_id) VALUES ({$this->getId()});");
        }

        function getCopies()
        {
            $query = $GLOBALS['DB']->query("SELECT book_id, count(1) FROM copies WHERE book_id = {$this->getId()} GROUP BY book_id;");

            $returned_copies = $query->fetchAll(PDO::FETCH_ASSOC);

                $count = $returned_copies[0]['count'];
                return $count;
            }

        }

?>
