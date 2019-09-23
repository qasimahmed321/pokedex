<?php

use Controllers\PokemonList;
use Controllers\ViewPokemon;
use Slim\App;
use Slim\Http\Environment;
use Slim\Http\Uri;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

require_once dirname(__DIR__) . "/vendor/autoload.php";


$app = new App([  'settings' => [
    'displayErrorDetails' => true,
    'debug'               => true,
    'whoops.editor'       => 'sublime',
]]);

$container = $app->getContainer();

$container['view'] = function ($c) {
    $view = new Twig('../src/Views/', []);
    $router = $c->get('router');
    $uri = Uri::createFromEnvironment(new Environment($_SERVER));
    $view->addExtension(new TwigExtension($router, $uri));

    return $view;
};

$container['ShowPokemons'] = function ($container){
    return new PokemonList($container);
};

$container['ViewPokemon'] = function ($container){
    return new ViewPokemon($container);
};

//Routes
$app->get('/', function ($request, $response, $args) {
    return $response->withRedirect('/PokemonList');
});
$app->get('/PokemonList[/{page}]', PokemonList::class);
$app->get('/Pokemon/{pokemon}', ViewPokemon::class);


$app->add(new Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware());
$app->run();
?>
