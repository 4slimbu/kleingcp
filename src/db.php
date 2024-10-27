<?php

function dbConnect(array $opts = [])
{
    // Prepare DSN (Data Source Name)
    $dsn = 'mysql:host=' . config('db.host') . ';dbname=' . config('db.db_name') . ';charset=utf8';

    try {
        // Create a new PDO instance
        $pdo = new PDO($dsn, config('db.user'), config('db.pass'), $opts);

        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo; // Return the PDO instance
    } catch (PDOException $e) {
        // Handle the error
        trigger_error('Connection failed: ' . $e->getMessage());
    }
}

