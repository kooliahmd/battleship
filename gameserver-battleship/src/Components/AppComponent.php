<?php

namespace App\Components;

use App\Authenticator;
use App\GameBuilder;
use App\GameController;
use App\GameRepository;
use App\MessageBuilder;
use App\Player;
use App\PlayerRepository;
use GuzzleHttp\Psr7\Request;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class AppComponent implements MessageComponentInterface
{
    /** @var Authenticator */
    private $authenticator;

    private $gameController;

    /** @var GameBuilder */
    private $gameBuilder;

    /** @var MessageBuilder */
    private $messageBuilder;

    /** @var GameRepository */
    private $gameRepository;

    /** @var PlayerRepository */
    private $playerRepository;

    public function __construct(
        Authenticator $authenticator,
        GameController $gameController,
        GameBuilder $gameBuilder,
        MessageBuilder $messageBuilder,
        GameRepository $gameRepository,
        PlayerRepository $playerRepository
    )
    {
        $this->authenticator = $authenticator;
        $this->gameController = $gameController;
        $this->gameBuilder = $gameBuilder;
        $this->messageBuilder = $messageBuilder;
        $this->gameRepository = $gameRepository;
        $this->playerRepository = $playerRepository;
    }

    /**
     * @param ConnectionInterface $conn
     * @throws \Exception
     */
    public function onOpen(ConnectionInterface $conn)
    {
        /** @var $httpRequest Request */
        $httpRequest = $conn->httpRequest;

        $userLocation = $this->authenticator->authenticate($httpRequest);
        $player = new Player($userLocation, $conn);

        $gameLocation = $this->getGameLocation($httpRequest);

        $game = $this->gameBuilder
            ->addPlayer($player)
            ->setLocation($gameLocation)
            ->build();
        $game->canStart() && $game->start();

        $this->gameRepository->save($game);
        $this->playerRepository->save($player);
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $message = $this->messageBuilder->build($msg);
        $player = $this->playerRepository->loadByConnection($from);
        switch ($message->getAction()) {
            case "init-board":
                $this->gameController->initBoard($player, $message->getInstruction());
                break;
            case "exec-shoot":
                $this->gameController->executeShoot($player, $message->getInstruction());
                break;
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
    }

    /**
     * @param Request $httpRequest
     * @return array
     * @throws \Exception
     */
    private function getGameLocation(Request $httpRequest): string
    {
        $query = $httpRequest->getUri()->getQuery();
        parse_str($query, $params);
        if (empty($params['game'])) {
            throw new \Exception("invalid game");
        }
        return $params['game'];
    }
}