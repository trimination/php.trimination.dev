<?php

namespace trimination;
class ExampleController {
    public \Closure $someRouteHandler;
    private ExampleModel $model;

    public function __construct() {
        $this->model = new ExampleModel();
        $this->prepareClosures();
    }

    private function prepareClosures(): void {
        // first class callable syntax; a pleasant change from: Closure::fromCallable([$this, 'method']);
        $this->someRouteHandler = $this->someView(...);
    }

    private function someView(): void {
        $someData = $this->model->exampleFn(10, true);
        new View('example', array("data"=>$someData));
    }
}