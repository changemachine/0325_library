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

    class CheckoutTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown(){
            Author::deleteAll();
            Book::deleteAll();
            Copy::deleteAll();
            Patron::deleteAll();
            Checkout::deleteAll();
        }

        // function test_addCheckout()
        // {
        //     //Arrange
        //     $name = "Carl";
        //     $contact = "000";
        //     $id = 1;
        //     $test_patron = new Patron($name, $contact, $id);
        //     $test_patron->save();
        //
        //     $patron_id = 1;
        //     $copy_id = 3;
        //     $duedate = '2015-03-26';
        //     $id2 = 2;
        //     $new_checkout = new Checkout($patron_id, $copy_id, $duedate, $id2);
        //     $new_checkout->save();
        //
        //     //Act
        //     $test_patron->addCheckout($new_checkout);
        //     $result = $test_patron->getChecks();
        // 
        //     //Assert
        //     $this->assertEquals([$new_checkout], $result);
        // }



    }

?>
