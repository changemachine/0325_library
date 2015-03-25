<?php

    /**
    * @backupGlobals disabled
    * $backupStaticAttribute disabled
    */

    $DB = new PDO('pgsql:host=localhost;dbname=library_test');

    require_once "src/Author.php";
    require_once "src/Book.php";
    require_once "src/Copy.php";

    class CopyTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown(){
            Author::deleteAll();
            Book::deleteAll();
            Copy::deleteAll();
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
    }

?>
