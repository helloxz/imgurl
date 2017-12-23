<?php

namespace Tinify;

class Exception extends \Exception {
    public $status;

    public static function create($message, $type, $status) {
        if ($status == 401 || $status == 429) {
            $klass = "Tinify\AccountException";
        } else if($status >= 400 && $status <= 499) {
            $klass = "Tinify\ClientException";
        } else if($status >= 500 && $status <= 599) {
            $klass = "Tinify\ServerException";
        } else {
            $klass = "Tinify\Exception";
        }

        if (empty($message)) $message = "No message was provided";
        return new $klass($message, $type, $status);
    }

    function __construct($message, $type = NULL, $status = NULL) {
        $this->status = $status;
        if ($status) {
            parent::__construct($message . " (HTTP " . $status . "/" . $type . ")");
        } else {
            parent::__construct($message);
        }
    }
}

class AccountException extends Exception {}
class ClientException extends Exception {}
class ServerException extends Exception {}
class ConnectionException extends Exception {}
