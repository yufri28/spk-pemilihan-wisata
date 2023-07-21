<?php

require 'autoload.php';

// Gunakan 'use' untuk mengimpor kelas Model dari namespace MyNamespace
use Spw\Model;

class test2 {

    private $db;
    public function __construct()
    {
        $this->db = new Model();
    }
    
}

$tes = new test2();