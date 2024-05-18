# SMTP-to-API

SMTP-to-API is a simple PHP script that exposes an SMTP server through a REST API. It allows you to send emails by sending a POST request to the `/send` endpoint.

## Table of Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [API Endpoint](#api-endpoint)
- [License](#license)

## Installation

1. Clone the repository:

    ```sh
    git clone https://github.com/russelljapheth/smtp-to-api.git
    cd smtp-to-api
    ```

2. Install the dependencies using Composer:

    ```sh
    composer install
    ```

3. Copy the `.env.example` file to `.env` and fill in your SMTP configuration details:

    ```sh
    cp .env.example .env
    ```

4. Generate a valid PHP password hash for your token:

    ```php
    <?php
    $token = password_hash('your-secret-token', PASSWORD_BCRYPT);
    echo $token;
    ?>
    ```

   Replace `your-secret-token` with your actual token string. You can generate one using the following command:

   ```sh
   openssl rand -hex 20
   ```

   Run this PHP code to get a hashed token and update the `TOKEN` field in your `.env` file.

## Configuration

Fill in your SMTP configuration details in the `.env` file:

```dotenv
# SMTP server configuration
SMTP_HOST=your_smtp_host
SMTP_PORT=your_smtp_port
SMTP_USER=your_smtp_user
SMTP_PASSWORD=your_smtp_password
SMTP_FROM=your_smtp_from_address

# Token for authentication (should be a valid PHP password hash generated using password_hash function in PHP)
TOKEN=your_password_hash

```

## Usage

Start the PHP built-in server or deploy the script on your web server making sure `./public` is your document root.

To start PHP's built-in server for local development:

```bash
./server.sh

```

## API Endpoint

### Send Email

- **URL**: `/send`
- **Method**: `POST`
- **Content-Type**: `application/json`
- **Authentication**: `token` in the request body

### Request Body

```json
{
  "subject": "Email Subject",
  "destination": "recipient@example.com",
  "body": "Email body content",
  "token": "your_secret_token"
}

```

### Response

- **Success**:
  - **Code**: 200
  - **Content**: `{"success": true}`
- **Validation Error**:
  - **Code**: 400
  - **Content**: JSON with error details
- **Invalid Token**:
  - **Code**: 403
  - **Content**: `{"error": "Invalid Token", "success": false}`
- **Internal Server Error**:
  - **Code**: 500
  - **Content**: `{"success": false}`

## License

This project is licensed under a modified version of the GLWT License. See the LICENSE file for details.
