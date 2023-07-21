<?php

namespace trimination;
class PostsController {

    public \Closure $home;
    public \Closure $post;
    private PostsModel $postModel;

    public function __construct() {
        $this->postModel = new \trimination\PostsModel();
        $this->prepareClosures();
    }

    private function prepareClosures(): void {
        // first class callable syntax; a pleasant change from: Closure::fromCallable([$this, 'method']);
        $this->home = $this->homeView(...);
        $this->post = $this->postView(...);
    }

    private function homeView(): void {
        $post = $this->postModel->getPostBySlug('home', true);
        new View('home', array("post" => $post));
    }

    private function postView($req, $slug): void {
        $post = $this->postModel->getPostBySlug($slug, true);
        new View('post', array("post" => $post));
    }
}