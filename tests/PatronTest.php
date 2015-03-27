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

    class PatronTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown(){
            Author::deleteAll();
            Book::deleteAll();
            Copy::deleteAll();
            Patron::deleteAll();
            Checkout::deleteAll();
        }

        // SET & GET PROPERTIES

        //SAVE GET-ALL, DELETE-ALL
        function test_save()
        {
            //Arrange
            $name = "Randall Witherspoon";
            $contact = "503-203-0000";
            $id = 1;
            $test_patron = new Patron($name, $contact, $id);
            //Act
            $test_patron->save();

            //Assert
            $result = Patron::getAll();
            $this->assertEquals($test_patron, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Tomothy Thompson";
            $contact = "500-000-0000";
            $id = 1;
            $test_patron = new Patron($name, $contact, $id);
            $test_patron->save();

            $name2 = "Stan Stanley";
            $contact2 = "500-500-0000";
            $id2 = 2;
            $test_patron2 = new Patron($name2, $contact2, $id2);
            $test_patron2->save();

            //Act
            $result = Patron::getAll();
            $this->assertEquals([$test_patron, $test_patron2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Create Dan";
            $contact = "400-000-0000";
            $id = 1;
            $test_patron = new Patron($name, $contact, $id);
            $test_patron->save();

            $name2 = "Sally Stanley";
            $contact2 = "300-330-5000";
            $id2 = 2;
            $test_patron2 = new Patron($name2, $contact2, $id2);
            $test_patron2->save();

            //Act
            Patron::deleteAll();
            $result = Patron::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        //FIND BY AUTHOR, UPDATE & DELETE AUTHOR
        function test_find()
        {
            //Arrange
            $name = "Cher";
            $contact = "100-100-3000";
            $id = 1;
            $test_patron = new Patron($name, $contact, $id);
            $test_patron->save();

            $name2 = "Sonny";
            $contact2 = "400-400-4000";
            $id2 = 2;
            $test_patron2 = new Patron($name2, $contact2, $id2);
            $test_patron2->save();

            //Act
            $result = Patron::find($test_patron->getId());

            //Assert
            $this->assertEquals($test_patron, $result);
        }

        function test_update()
        {
            //Arrange
            $name = "Carl";
            $contact = "000-000-0000";
            $id = 1;
            $test_patron = new Patron($name, $contact, $id);
            $test_patron->save();
            $new_name = "Carly";
            $new_contact = "100-300-4000";

            //Act
            $test_patron->update($new_name, $new_contact);

            //Assert
            $this->assertEquals(['Carly', '100-300-4000'], [$test_patron->getName(), $test_patron->getContact()]);
        }

        function test_deletePatron()
        {
            //Arrange
            $name = "Cher";
            $contact = "000";
            $id = 1;
            $test_patron = new Patron($name, $contact, $id);
            $test_patron->save();

            $name2 = "Sonny";
            $contact2 = "001";
            $id2 = 2;
            $test_patron2 = new Patron($name2, $contact2, $id2);
            $test_patron2->save();

            //Act
            $test_patron2->deletePatron();
            $result = Patron::getAll();

            //Assert
            $this->assertEquals([$test_patron], $result);

        }

        // CREATE, GET COPIES


        // function test_getChecks()
        // {
        //     $name = "Carl";
        //     $contact = "000";
        //     $id = 1;
        //     $test_patron = new Patron($name, $contact, $id);
        //     $test_patron->save();
        //
        //     $book_id = 1;
        //     $id2 = 2;
        //     $new_checkout = new Copy($book_id, $id2);
        //     $new_checkout->save();
        //
        //     $book_id3 = 2;
        //     $id3 = 3;
        //     $new_checkout3 = new Copy($book_id3, $id3);
        //     $new_checkout3->save();
        //
        //     $test_patron->addCheckout($new_checkout);
        //     $test_patron->addCheckout($new_checkout3);
        //
        //     $result = $test_patron->getChecks();
        //     $this->assertEquals([$new_checkout, $new_checkout3], $result);
        // }








    }

?>
