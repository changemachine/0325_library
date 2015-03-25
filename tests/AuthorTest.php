<?php


    /**
    * @backupGlobals disabled
    * $backupStaticAttribute disabled
    */

    $DB = new PDO('pgsql:host=localhost;dbname=library_test');

    require_once "src/Author.php";
    // require_once "src/Book.php";

    class AuthorTest extends PHPUnit_Framework_TestCase
    {

        // SET & GET PROPERTIES
        function test_setAuthor1()
        {
            //Arrange
            $author1 = "Mark Twain";
            $author2 = "Willa Kather";
            $author3 = "Ursela LeGuin";
            $test_author = new Author($author1, $author2, $author3);

            //Act
            $test_author->setAuthor1("Samuel Clemens");
            $test_author->setAuthor2("Willa Cather");
            $test_author->setAuthor3("Ursela K. Leguin");
            $author1 = $test_author->getAuthor1();
            $author2 = $test_author->getAuthor2();
            $author3 = $test_author->getAuthor3();

            //$result = array();
            $result1 = $test_author->getAuthor1();
            $result2 = $test_author->getAuthor2();
            $result3 = $test_author->getAuthor3();

            //Assert
            $this->assertEquals([$author1, $author2, $author3], [$result1, $result2, $result3]);
        }

        //SAVE GET-ALL, DELETE-ALL



        //FIND BY AUTHOR, UPDATE & DELETE AUTHOR






    }

?>
