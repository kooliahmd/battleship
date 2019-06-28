<?php

use App\GameBuilder;
use App\GameController;
use App\GameRepository;
use App\MessageBuilder;
use App\PlayerRepository;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Components\AppComponent;

use App\Authenticator;

require dirname(__DIR__) . '/vendor/autoload.php';

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            buildAppComponent()
        )
    ),
    8080
);

function buildAppComponent()
{
    $gameRepository = new GameRepository();
    return new AppComponent(
        new Authenticator(),
        new GameController(
            $gameRepository
        ),
        new GameBuilder($gameRepository),
        new MessageBuilder(),
        $gameRepository,
        new PlayerRepository
    );
}

$server->run();