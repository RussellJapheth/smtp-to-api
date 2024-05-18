<?php

use Rakit\Validation\Validator;

require_once __DIR__.'/../bootstrap.php';

/**
 * Route for sending an email.
 * Validates the input data and sends an email if the data is valid and the token is correct.
 *
 * @return void
 */
Flight::route(
    '/send',
    function () {
        $validator = new Validator();

        // Retrieve request data
        $data = [
            'subject'     => Flight::request()->data?->subject,
            'destination' => Flight::request()->data?->destination,
            'body'        => Flight::request()->data?->body,
            'token'       => Flight::request()->data?->token,
        ];

        // Define validation rules
        $rules = [
            'subject'     => 'required',
            'destination' => 'required|email',
            'body'        => 'required',
            'token'       => 'required',
        ];

        // Validate the data
        $validation = $validator->make($data, $rules);
        $validation->validate();

        // Handle validation failures
        if ($validation->fails()) {
            Flight::halt(
                400,
                json_encode($validation->errors()->toArray())
            );
        }

        // Verify token
        if (!password_verify($data['token'], $_ENV['TOKEN'])) {
            Flight::halt(
                403,
                json_encode(
                    [
                        'error' => 'Invalid Token',
                        'success' => false
                    ]
                )
            );
        }

        // Send the email
        $email = new \App\Utils\Email();
        $sent = $email->send($data['destination'], $data['subject'], $data['body']);

        // Handle the email sending result
        if ($sent) {
            Flight::halt(200, json_encode(['success' => true]));
        } else {
            Flight::halt(500, json_encode(['success' => false]));
        }
    }
);

Flight::start();
