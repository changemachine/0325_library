<?php

    class Checkout
    {

    private $patron_id;
    private $copy_id;
    private $duedate;
    private $id;

    function __construct($patron_id, $copy_id, $duedate, $id)
    {
        $this->patron_id = $patron_id;
        $this->copy_id = $copy_id;
        $this->duedate = $duedate;
        $this->id = $id;
    }

    //SET GET PROPS
    function setPatronId($new_patron_id)
    {
        $this->patron_id = (int) $new_patron_id;
    }

    function getPatronId()
    {
        return $this->patron_id;
    }

    function setCopyId($new_copy_id)
    {
        $this->copy_id = (int) $new_copy_id;
    }

    function getCopyId()
    {
        return $this->copy_id;
    }

    function setDueDate($new_duedate)
    {
        $this->duedate = (string) $new_duedate;
    }

    function getDueDate()
    {
        return $this->duedate;
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
        $statement = $GLOBALS['DB']->query("INSERT INTO checkouts (patron_id, copy_id, duedate) VALUES ({$this->getPatronId()}, {$this->getCopyId()}, '{$this->getDueDate()}') RETURNING id;");
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $this->setId($result['id']);
    }

    static function getAll()
    {
        $returned_checkouts = $GLOBALS['DB']->query("SELECT * FROM checkouts;");
        $checkouts = array();
        foreach ($returned_checkouts as $checkout){
            $patron_id = $checkout['patron_id'];
            $copy_id = $checkout['copy_id'];
            $duedate = $checkout['duedate'];
            $id = $checkout['id'];
            $new_checkout = new Checkout($patron_id, $copy_id, $duedate, $id);
            array_push($checkouts, $new_checkout);
        }
        return $checkouts;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM checkouts *;");
    }


    // √ FIND CHECKOUT, UPDATE, DELETE INSTANCE

        static function find($search_id)
        {
            $found_checkout = null;
            $checkouts = Checkout::getAll();
            foreach($checkouts as $checkout){
                $checkout_id = $checkout->getId();
                if($checkout_id == $search_id){
                    $found_checkout = $checkout;
                }
            }
            return $found_checkout;
        }

        function update($new_patron_id, $new_copy_id, $new_duedate)
        {
            $GLOBALS['DB']->exec("UPDATE checkouts SET patron_id = {$new_patron_id} WHERE id = {$this->getId()};");
            $this->setPatronId($new_patron_id);
            $GLOBALS['DB']->exec("UPDATE checkouts SET copy_id = {$new_copy_id} WHERE id = {$this->getId()};");
            $this->setCopyId($new_copy_id);
            $GLOBALS['DB']->exec("UPDATE checkouts SET duedate = '{$new_duedate}' WHERE id = {$this->getId()};");
            $this->setDueDate($new_duedate);
        }

        function deleteCheckout()
        {
            $GLOBALS['DB']->exec("DELETE FROM checkouts WHERE id = {$this->getId()};");
            // JOIN TABLE!
        }

        // function addCheckout()
        // {
        //     $GLOBALS['DB']->exec("INSERT INTO checkouts (patron_id, copy_id, duedate) VALUES ({$this->getPatronId()}, {$this->getCopyId()}, '{$this->getDueDate()}');");
        // }


        // function getChecks()
        // {
        //     $query = $GLOBALS['DB']->query("SELECT copies.* FROM checkouts
        //         JOIN checkouts ON (checkouts.id = checkouts.patron_id)
        //         JOIN copies ON (checkouts.copy_id = copies.id)
        //         WHERE checkouts.id = {$this->getId()};");
        //
        //     $returned_checkouts = $query->fetchAll(PDO::FETCH_ASSOC);
        //
        //     $checkouts = array();
        //     foreach($returned_checkouts as $checkout){
        //         $book_id = $checkout['book_id'];
        //         $id = $checkout['id'];
        //         $checked_out = new Copy($book_id, $id);
        //         array_push($checkouts, $checked_out);
        //     }
        //     return $checkouts;
        // }


        }

?>
