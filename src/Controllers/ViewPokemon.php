<?php


namespace Controllers;

use PokePHP\PokeApi;
use Controllers\ParseAPI;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Container;


class ViewPokemon
{
    protected $container = null;
    protected $pokeAPI = null;
    protected $parser = null;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->pokeAPI = new PokeApi();
        $this->parser = new ParseAPI();
    }

    private function apiCall($pokemon){
        return $this->pokeAPI->pokemon($pokemon);
    }

    private function pokemonCheck($args, $response, $view){
        if(!isset($args['pokemon'])){
            $view->render($response, "error.html.twig");
        }
    }

    private function processImages($images){
        $set = [];
        foreach ($images as $key=>$image){
            if($image){
                $set[$key] = $image;
            }
        }
        return $set;
    }

    public function __invoke(Request $request, Response $response, $args){
        $view = $this->container->get("view");
        $this->pokemonCheck($args, $response, $args);

        $info = $this->parser->verify_return($this->apiCall($args['pokemon']),[$view, $response]);
        if($info != false){
            $view->render($response, "Pokemon.html.twig", [
                "name"=>$info['name'],
                "height"=>($info["height"]/10),
                "weight"=>($info["weight"]/10),
                "species"=>$info["species"]['name'],
                "abilities"=>$info["abilities"],
                "sprites"=>array_reverse($this->processImages($info['sprites']))
            ]);
        }

    }
}
