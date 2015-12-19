<?php
require 'vendor/autoload.php';

// Create container
$container = new \Slim\Container;

// Register component on container
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig('templates', [
        'cache' => 'templates'
    ]);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $c['router'],
        $c['request']->getUri()
    ));

    return $view;
};

$app = new \Slim\App($container);

// Define app routes
$app->get('/', function ($request, $response, $args) {
	return $this->view->render($response, 'index.html',[
		'var1' => 'test'
	]);
})->setName('PasteBukket');

$app->get('/api/version/', function ($request, $response, $args) {
	$data = array(
			"platform" => "pastebukket",
			"version" => "0.1"
		);

	return $response->write(json_encode($data));
});

// Run app
$app->run();
