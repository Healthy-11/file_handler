<?php

class FileObject
{
    private $name;
    private $type;
    private $date;

    public function __construct($name, $type, $date)
    {
        $this->name = $name;
        $this->type = $type;
        $this->date = $date;
    }

    public function print()
    {
        echo "name => " . $this->name . "\nType => " . $this->type . "\nDate => " . $this->date;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }
}