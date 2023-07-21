<?php

namespace trimination;
class Helper {
    /**
     * check if a string contains a substring, with or without
     * case sensitivity. Originally written pre PHP 8. Still
     * used for case insensitivity.
     * @param string $needle
     * @param string $haystack
     * @param bool $caseSensitive
     * @return bool
     */
    public static function str_contains(string $needle, string $haystack, bool $caseSensitive = false): bool {
        if ($caseSensitive) {
            if (str_contains($haystack, $needle)) {
                return true;
            }
        } else {
            if (str_contains(strtolower(strtolower($haystack)), strtolower($needle))) {
                return true;
            }
        }
        return false;
    }

    /**
     * prepare a JSON response string for a status return
     * Ex: {status:200, data: "OK"}
     * @param $code
     * @param $msg
     * @param null $additional
     * @return string
     */
    public static function return_status_json($code, $msg, $additional = null): string {
        $json['status'] = $code;
        $json['message'] = $msg;
        if ($additional !== null)
            $json['additional_information'] = $additional;
        return json_encode($json);
    }

    /**
     * check if an associative array contains all keys
     * listed in a provided array
     * @param $requiredParams
     * @param $params
     * @return bool
     */
    public static function has_all_params($requiredParams, $params): bool {
        foreach ($requiredParams as $requiredParam) {
            if (!array_key_exists($requiredParam, $params)) {
                return false;
            }
        }
        return true;
    }

    public static function random_404_quote() {
        $quotes = [
            '⚙️ The cogs stopped turning!',
            'A shadowy figure stands tall in place of the page that never was.',
            'Uh-oh, somebody somewhere somehow broke the matrix!',
            'There\'s nothing here, friend!',
            '🕰️ You\'re too late or too early, but not on time.',
            '😔 Where is the content?!',
            '🥶 It\'s too cold to load this page.'
        ];
        $r = rand(0, count($quotes) - 1);

        return $quotes[$r];
    }

    public static function ucfirst($str) {
        if(strlen($str) === 0) return $str;
        return strtoupper($str[0]) . substr($str, 1);
    }
}