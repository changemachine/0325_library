<?php

    class Patron
    {

    private $name;
    private $contact;
    private $id;

    function __construct($name, $contact, $id)
    {
        $this->name = $name;
        $this->contact = $contact;
        $this->id = $id;
    }

    //SET GET PROPS
    function setName($new_name)
    {
        $this->name = (string) $new_name;
    }

    function getName()
    {
        return $this->name;
    }

    function setContact($new_contact)
    {
        $this->contact = (string) $new_contact;
    }

    function getContact()
    {
        return $this->contact;
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
        $statement = $GLOBALS['DB']->query("INSERT INTO patrons (name, contact) VALUES ('{$this->getName()}', '{$this->getContact()}') RETURNING id;");
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $this->setId($result['id']);
    }

    static function getAll()
    {
        $returned_patrons = $GLOBALS['DB']->query("SELECT * FROM patrons;");
        $patrons = array();
        foreach ($returned_patrons as $patron){
            $name = $patron['name'];
            $contact = $patron['contact'];
            $id = $patron['id'];
            $new_patron = new Patron($name, $contact, $id);
            array_push($patrons, $new_patron);
        }
        return $patrons;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM patrons *;");
    }


    // √ FIND BY AUTHOR, UPDATE & DELETE AUTHOR

        static function find($search_id)
        {
            $found_patron = null;
            $patrons = Patron::getAll();
            foreach($patrons as $patron){
                $patron_id = $patron->getId();
                if($patron_id == $search_id){
                    $found_patron = $patron;
                }
            }
            return $found_patron;
        }

        function update($new_name, $new_contact)
        {
            $GLOBALS['DB']->exec("UPDATE patrons SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
            $GLOBALS['DB']->exec("UPDATE patrons SET contact = '{$new_contact}' WHERE id = {$this->getId()};");
            $this->setContact($new_contact);
        }

        function deletePatron()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons WHERE id = {$this->getId()};");
            // JOIN TABLE!
        }


        function getChecks()
        {
            $query = $GLOBALS['DB']->query("SELECT copies.* FROM patrons
                JOIN checkouts ON (patrons.id = checkouts.patron_id)
                JOIN copies ON (checkouts.copy_id = copies.id)
                WHERE patrons.id = {$this->getId()};");

            $returned_checkouts = $query->fetchAll(PDO::FETCH_ASSOC);

            $checkouts = array();
            foreach($returned_checkouts as $checkout){
                $patron_id = $checkout['patron_id'];
                $copy_id = $checkout['copy_id'];
                $duedate = $checkout['duedate'];
                $id = $checkout['id'];
                $checked_out = new Checkout($patron_id, $copy_id, $duedate, $id);
                array_push($checkouts, $checked_out);
            }
            return $checkouts;
        }


        }

?>
