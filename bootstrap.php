<?php

require_once __DIR__.'/vendor/autoload.php';

use Dotenv\Dotenv;

/**
 * Initializes environment variables from a .env file.
 *
 * This script loads the environment variables from the .env file located in the
 * same directory. It also ensures that the required environment variables are set.
 */

// Create a Dotenv instance and load the .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Ensure required environment variables are set
$dotenv->required(
    [
        'SMTP_HOST',
        'SMTP_PORT',
        'SMTP_USER',
        'SMTP_PASSWORD',
        'SMTP_FROM',
        'TOKEN'
    ]
);
