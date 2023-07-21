<?php
namespace router;
use stdClass;
use trimination\Helper;
use trimination\View;

class Router {

    private Request $request;
    private array $all = array();

    private array $supportedHttpMethods = array(
        "GET",
        "POST",
        "PUT",
        "DELETE",
        "OPTIONS"
    );

    function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * @param $name - The calling function name
     * @param $args - An array of args passed to the calling function
     *
     * This handles calls to functions that do not exist within this class, such as
     * Router::get, Router::post, Router::put, Router::delete.
     */
    function __call($name, $args) {
        if ($name == "all") {
            list($exemptRoute, $method) = $args;
            $exemptRoute = ($exemptRoute === null) ? null : $exemptRoute;

            $object = new stdClass();
            $object->method = $method;
            $object->exemptRoute = $exemptRoute;

            $this->all[] = $object;
            return;
        } else if (!in_array(strtoupper($name), $this->supportedHttpMethods)) {
            $this->invalidMethodHandler();
            return;
        }
        list($route, $method) = $args;
        $this->{strtolower($name)}[] = new RequestObject($this->formatRoute($route), $method);
    }

    /**
     * Removes trailing forward slashes from the right of the route.
     * @param route (string)
     */
    private function formatRoute($route) {
        $result = rtrim($route, '/');
        if ($result === '') {
            return '/';
        }
        return $result;
    }

    private function invalidMethodHandler() {
        header("{$this->request->serverProtocol} 405 Method Not Allowed");
        die(Helper::return_status_json(405, 'Method Not Allowed'));
    }

    private function defaultRequestHandler() {
        header("{$this->request->serverProtocol} 404 Not Found");
        die(Helper::return_status_json(404, '404 Not Found'));
    }

    private function _404() {
        header("{$this->request->serverProtocol} 404 Not Found");
        new View('404');
        die();
    }
    /**
     * Resolves a route
     */
    function resolve() {
        // method dictionary = route, function as k,v
        $method = null;
        $methodDictionary = $this->{strtolower($this->request->requestMethod)};
        $formattedRoute = $this->formatRoute($this->request->requestUri);
        $data = null;
        $exemptRoute = false;

        if ($formattedRoute == "/" . PROJECT_DIR)
            $formattedRoute = "/";
        else
            $formattedRoute = str_replace('/' . PROJECT_DIR, '', $this->formatRoute($this->request->requestUri));

        foreach ($methodDictionary as $requestObj) {
            if ($formattedRoute == $requestObj->getUri()) {
                $method = $requestObj->getMethod();
                break;
            } else if ($requestObj->isRoute($formattedRoute)) {
                $method = $requestObj->getMethod();
                $data = $requestObj->getParams();
                break;
            }
        }

        $this->request->headers = apache_request_headers();

        foreach ($this->all as $a) {
            if (is_array($a->exemptRoute)) {
                foreach ($a->exemptRoute as $ex) {
                    if (Helper::str_contains($ex->getRoute(), $formattedRoute) && $ex->getRequestMethod() == $this->request->requestMethod) {
                        $exemptRoute = true;
                        break;
                    } else if(Helper::str_contains($ex->getRoute(), $formattedRoute)) {
                        $this->invalidMethodHandler();
                        return;
                    }
                }
            } else {
                if (Helper::str_contains($a->exemptRoute->getRoute(), $formattedRoute) && $a->exemptRoute->getRequestMethod() == $this->request->requestMethod) {
                    $exemptRoute = true;
                    break;
                } else if (Helper::str_contains($a->exemptRoute->getRoute(), $formattedRoute)) {
                    $this->invalidMethodHandler();
                    return;
                }
            }

            if (is_null($method)) {
                $this->defaultRequestHandler();
                return;
            }


            if ($exemptRoute === false) {
                try {
                    if($data === null)
                        call_user_func_array($a->method, array($this->request, null));
                    else
                        call_user_func_array($a->method, array($this->request, ...$data));
                } catch (\ArgumentCountError $e) {
                    $this->_404();
                }
            }
        }
        try {
            if($data === null)
                call_user_func_array($method, array($this->request, null));
            else
            call_user_func_array($method, array($this->request, ...$data));
        } catch (\ArgumentCountError | \TypeError $e) {
            $this->_404();
        }
    }

    function __destruct() {
        $this->resolve();
    }
}