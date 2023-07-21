<?php
namespace router;
use stdClass;

class Request {
    static string $GET      = "GET";
    static string $POST     = "POST";
    static string $PUT      = "PUT";
    static string $DELETE   = "DELETE";

    function __construct() {
        $this->bootstrapSelf();
    }

    private function bootstrapSelf() {
        foreach ($_SERVER as $key => $value) {
            $this->{$this->toCamelCase($key)} = $value;
        }
    }

    private function toCamelCase($string) {
        $result = strtolower($string);

        preg_match_all('/_[a-z]/', $result, $matches);

        foreach ($matches[0] as $match) {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }

        return $result;
    }

    public function getBody($useObj = false) {
        if ($this->requestMethod === "GET") {
            return;
        }

        if ($this->requestMethod == "POST") {

            $body = array();
            if($useObj) {
                $object = new stdClass();
                foreach ($_POST as $key => $value) {
                    $object->{$key} = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
                $body = $object;
            } else {
                foreach ($_POST as $key => $value) {
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }

            return $body;
        }

        if($this->requestMethod == "PUT") {
            parse_str(file_get_contents("php://input"),$post_vars);
            return $post_vars;
        }

        if($this->requestMethod == "DELETE") {
            return;
        }

        if($this->requestMethod == "OPTIONS") {
            return;
        }
    }
}