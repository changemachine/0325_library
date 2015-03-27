<?php

    /**
    * @backupGlobals disabled
    * $backupStaticAttribute disabled
    */

    $DB = new PDO('pgsql:host=localhost;dbname=library_test');

    require_once "src/Author.php";
    require_once "src/Book.php";
    require_once "src/Copy.php";
    require_once "src/Patron.php";
    require_once "src/Checkout.php";

    class CopyTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown(){
            Author::deleteAll();
            Book::deleteAll();
            Copy::deleteAll();
            Patron::deleteAll();
            Checkout::deleteAll();

        }

        function test_save()
        {
            //Arrange
            $book_id = 2;
            $id = 1;
            $test_copy = new Copy($book_id, $id);
            //Act
            $test_copy->save();

            //Assert
            $result = Copy::getAll();
            $this->assertEquals($test_copy, $result[0]);
        }

        function test_find()
        {
            //Arrange
            $book_id = 1;
            $id = 1;
            $test_copy = new Copy($book_id, $id);
            $test_copy->save();

            $book_id2 = 2;
            $id2 = 2;
            $test_copy2 = new Copy($book_id2, $id2);
            $test_copy2->save();

            //Act
            $result = Copy::find($test_copy->getId());

            //Assert
            $this->assertEquals($test_copy, $result);
        }

        function test_updateCopy()
        {
            //Arrange
            $book_id = 5;
            $id = 4;
            $new_book_id = 12;
            $test_copy = new Copy($book_id, $id);
            $test_copy->save();


            //Act
            $test_copy->updateCopy($new_book_id);
            $result = $test_copy->getBookId();

            //Assert
            $this->assertEquals($new_book_id, $result);
        }

        function test_deleteCopy()
        {
            //Arrange
            $book_id = 5;
            $id = 4;
            $test_copy = new Copy($book_id, $id);
            $test_copy->save();

            $book_id2 = 2;
            $id2 = 2;
            $test_copy2 = new Copy($book_id2, $id2);
            $test_copy2->save();

            //Act
            $test_copy2->deleteCopy();
            $result = Copy::getAll();

            //Assert
            $this->assertEquals([$test_copy], $result);
        }

        function test_addCheckout()
        {
            //Arrange
            $title = "Create";
            $genre = 'scific';
            $id = 1;
            $new_book = new Book($title, $genre, $id);
            $new_book->save();
            
            $book_id = $new_book->getBookId();
            $id3 = 3;
            $new_copy = new Copy($book_id, $id3);
            $new_copy->save();

            $name = 'Bart';
            $contact = '999-000-8888';
            $id4 = 4;
            $patron = new Patron($name, $contact, $id4);
            $patron->save();

            $patron_id = $patron->getPatronId();
            $copy_id = $new_copy->getCopyId();
            $duedate = '2015-09-07';
            $id5 = 5;
            $new_checkout = new Checkout($patron_id, $copy_id, $duedate, $id5);
            $new_checkout->save();
            //var_dump($new_checkout);

            //Act
            $new_copy->addCheckout($new_checkout);
            $result = Checkout::getAll();

            //Assert
            $this->assertEquals([$new_checkout], $result);
        }








    }

?>
