<?php

    namespace Source\Models;
    use Source\MySql;

    abstract Class Model
    {
        protected $pdo;

        public function __construct()
        {
            $db = (new MySql)->connect(); 
            $this->pdo = $db;
        }


    }