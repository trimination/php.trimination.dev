<?php
namespace router;
use Closure;
use trimination\Helper;

class RequestObject {
    private string $uri;
    private string $uriWithoutPlaceholder;
    private array $params;
    private array $paramPlaceholders;
    private Closure $method;

    public function __construct($uri, $method) {
        $this->paramPlaceholders = [];
        $this->uri = $uri;
        $this->method = $method;

        $this->extractParamPlaceholder();
    }

    private function extractParamPlaceholder() {
        $tmp = null;
        if (preg_match_all('/:\w+/', $this->uri, $tmp) > 0) {
            foreach ($tmp[0] as $key => $val) {
                $this->paramPlaceholders[] = $val;
                if ($key === 0) {
                    $this->uriWithoutPlaceholder = str_replace(
                        '/' . $val,
                        '',
                        $this->uri);
                } else {
                    $this->uriWithoutPlaceholder = str_replace(
                        '/' . $val,
                        '',
                        $this->uriWithoutPlaceholder);
                }
            }
        }
    }

    /**
     * @return string
     */
    public function getUri(): string {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getParams(): array {
        return $this->params;
    }

    /**
     * @return string
     */
    public function getParamPlaceholder(): array {
        return $this->paramPlaceholders;
    }

    public function isRoute($givenUri) {
        if (count($this->paramPlaceholders) === 0) {
            if ($givenUri == $this->uri) {
                return true;
            } else {
                return false;
            }
        } else {
            $uriWithoutPlaceholderSegments = explode('/', $this->uriWithoutPlaceholder);
            $uriWithoutPlaceholderSegmentsCount = count($uriWithoutPlaceholderSegments);
            $uriSegments = explode('/', $givenUri);
            $uriSegmentsCount = count($uriSegments);
            $placeholderCount = count($this->paramPlaceholders);

            if($uriSegmentsCount > 1 && $uriWithoutPlaceholderSegmentsCount > 1) {
                if ($uriSegments[1] != $uriWithoutPlaceholderSegments[1] || $uriSegmentsCount !== ($placeholderCount + $uriWithoutPlaceholderSegmentsCount)) {
                    return false;
                }
            }

            if (Helper::str_contains($this->uriWithoutPlaceholder, $givenUri)) {
                $this->params = explode('/', str_replace($this->uriWithoutPlaceholder, '', $givenUri));
                if ($this->params[0] == "") unset($this->params[0]);
                return true;
            }
        }
        return false;
    }

    /**
     * @return Closure
     */
    public function getMethod(): Closure {
        return $this->method;
    }
}