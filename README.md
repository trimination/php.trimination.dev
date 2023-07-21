# php.trimination.dev

**Author**: _trimination/JustTrim_

A simple PHP project to route requests and serve dynamic content.
Can be used to serve dynamic content directly or as an API service.

### Structure and Usage

The root _index.php_ file takes pre-defined routes and returns a
`View()` or `Endpoint()` via a `controller`. Each `router` method takes
a route and a `Closure`.

Views and endpoints are stored in `views/templates` and `views/endpoints`
respectively and should be instantiated via a controller.

Controllers should be created in the `controllers` directory;
any PHP files within `models` and `controllers` are autoloaded.

#### Supported Request Methods:

```
GET,
POST,
PUT,
DELETE,
OPTIONS
```

#### Example Routes

```php
// index.php
$router->get('/', $postsController->home);
$router->get('/:slug', $postsController->post);
$router->get('/', function() {
  new \trimination\View('view_name');
});
```

#### Getting params in the controller

The `Request()` is the first argument passed to controller functions,
and url parameters defined in the route are passed as additional arguments
to the controller function.

For example, `:slug` is passed as the second argument to `postView()`:

```php
function postView($req, $slug): void {}
```

#### Getting params in the view

You can access params such as `post` in the view by passing them to
the view like so:

```php
// PostController.php
function postView($req, $slug): void {
    $post = $this->postModel->getPostBySlug($slug, true);
    new View('post', array("post" => $post));
}
```

This will call the View `post.php` and pass the value of `$post` with the
variable name `$post` to `post.php`. Note that because of this design choice, accessing
`$slug` within `post.php` may show as an error in your IDE. We can then
simply access `$post` in `post.php`.

`Endpoint()` works in the same way. It does not, however, support
data input because I had no need for that on this project. `php://input` comes to mind.

##### CORS

Everyone's worst nightmare. You can enable CORS by uncommenting:

```php
\trimination\cors();
```

in `index.php` and modify `cors.php` accordingly.

##### Final Notes

This is more of a demo project than anything else, designed to showcase
PHP. If you do find yourself using this project, you can probably delete
the following content to start with a clean foundation:

- css directory contents
- js directory contents
- models/PostsModel.php
- controllers/PostsController.php
- views/templates/home.php
- views/templates/post.php

##### and modify the following content:

- views/templates/ -> header.php, footer.php, 404.php
- config/Config.php
- cors.php
- 404.php

Alternatively, using something more robust like Laravel, Symfony or Code Igniter
😁