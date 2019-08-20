<?php


namespace App\Service;


use App\Helper\LoggerTrait;
use Http\Client\Exception;
use Nexy\Slack\Client;
use Psr\Log\LoggerInterface;

class SlackClient
{
	use LoggerTrait;

	/** @var Client */
	private $slack;

	/**
	 * SlackClient constructor.
	 * @param Client $slack
	 */
	public function __construct(Client $slack)
	{
		$this->slack = $slack;
	}

	/**
	 * @param string $from
	 * @param string $message
	 * @throws Exception
	 */
	public function sendMessage(string $from, string $message)
	{
		$this->logInfo('Beaming a message to Slack!',
			['message' => $message]
		);
		$slackMessage = $this->slack->createMessage()
			->from($from)
			->withIcon(':ghost:')
			->setText($message);
		$this->slack->sendMessage($slackMessage);
	}
}