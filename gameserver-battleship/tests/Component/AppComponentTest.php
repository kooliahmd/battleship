<?php

namespace App\Tests\Component;

use App\Authenticator;
use App\Components\AppComponent;
use App\GameBuilder;
use App\GameController;
use App\GameRepository;
use App\MessageBuilder;
use App\PlayerRepository;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Ratchet\ConnectionInterface;

class AppComponentTest extends TestCase
{
    /**
     * @var GameRepository
     */
    private $gameRepository;

    public function setUp(): void
    {
        $this->gameRepository = new GameRepository();
    }

    public function test_create_game_on_open()
    {
        $component = $this->buildComponent();
        $conn = $this->buildConnection("token1");
        $component->onOpen($conn);
        $this->assertNotEmpty($this->gameRepository->load("some_game"));
    }

    public function test_init_player2_on_open()
    {
        $component = $this->buildComponent();
        $conn = $this->buildConnection("token1");
        $component->onOpen($conn);

        $conn = $this->buildConnection("token2");
        $component->onOpen($conn);

        $game = $this->gameRepository->load("some_game");
        $this->assertCount(2, $game->getPlayers());
    }

    public function test_init_board()
    {
        $component = $this->buildComponent();
        $conn = $this->buildConnection("token1");
        $component->onOpen($conn);
        $conn = $this->buildConnection("token2");
        $component->onOpen($conn);

        $component->onMessage($conn, json_encode(
            [
                'type' => 'init-board',
                'instruction' => [
                    ['size' => 3, 'orientation' => 'n', 'position' => ['x' => 2, 'y' => 3]],
                    ['size' => 2, 'orientation' => 'e', 'position' => ['x' => 4, 'y' => 2]],

                ]
            ]
        ));
        $this->assertTrue(true);

    }

    public function test_execute_shoot()
    {
        $component = $this->buildComponent();

        $conn1 = $this->buildConnection("token1");
        $component->onOpen($conn1);

        $conn2 = $this->buildConnection("token2");
        $component->onOpen($conn2);

        $component->onMessage($conn2, json_encode(
            [
                'type' => 'init-board',
                'instruction' => [
                    ['size' => 2, 'orientation' => 's', 'position' => ['x' => 4, 'y' => 2]],
                ]
            ]
        ));

        $component->onMessage($conn1, json_encode(
            [
                'type' => 'exec-shoot',
                'instruction' => ['position' => ['x' => 2, 'y' => 3]]
            ]
        ));
        $this->assertTrue(true);
    }

    private function buildComponent(): AppComponent
    {
        $component = new AppComponent(
            new Authenticator(),
            new GameController($this->gameRepository),
            new GameBuilder($this->gameRepository),
            new MessageBuilder(),
            $this->gameRepository,
            new PlayerRepository()
        );
        return $component;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject
     * @throws \ReflectionException
     */
    public function buildConnection($token, $gameLocation = "some_game"): \PHPUnit\Framework\MockObject\MockObject
    {
        $conn = $this->createMock(ConnectionInterface::class);
        $request = $this->createMock(Request::class);
        $uri = $this->createMock(UriInterface::class);
        $uri->method("getQuery")->willReturn("access_token=$token&game=$gameLocation");
        $request->method("getUri")->willReturn($uri);
        $conn->httpRequest = $request;
        return $conn;
    }
}