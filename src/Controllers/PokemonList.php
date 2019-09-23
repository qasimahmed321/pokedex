<?php


namespace Controllers;

use PokePHP\PokeApi;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Container;

class PokemonList
{
    protected $container = null;
    protected $pokeAPI = null;
    protected $parser = null;
    private $pageCount = 40;
    private $page = 1;
    private $offset = 0;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->pokeAPI = new PokeApi();
        $this->parser = new ParseAPI();
    }

    private function apiCall(){
        return $this->pokeAPI->resourceList("pokemon",$this->pageCount, $this->offset);
    }

    private function setPage($args){
        if(isset($args['page'])){
            if(($args['page']-1)<1){
                $args['page'] = 1;
            }
            $this->offset = ($args['page']-1)*$this->pageCount;
            $this->page = $args['page'];
        }
        return $this->page;
    }

    public function __invoke(Request $request, Response $response, $args){
        $this->setPage($args);
        $view = $this->container->get("view");
        $pokes = $this->parser->verify_return($this->apiCall(),[$view, $response]);
        $view->render($response, "PokemonList.html.twig", ["pokemons"=>$pokes['results'], "count"=>$pokes['count'], "page"=>$this->page]);
    }

}
