<?php

namespace App\Twig;

use App\Service\MarkdownHelper;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension implements ServiceSubscriberInterface
{
	/** @var ContainerInterface */
	private $container;

	/**
	 * AppExtension constructor.
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	public function getFilters(): array
	{
		return [
			// If your filter generates SAFE HTML, you should add a third
			// parameter: ['is_safe' => ['html']]
			// Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
			new TwigFilter('cached_markdown', [$this, 'processMarkdown'], ['is_safe' => ['html']]),
		];
	}

	/**
	 * @param $value
	 * @return string
	 * @throws \Psr\Cache\InvalidArgumentException
	 */
	public function processMarkdown($value)
	{
		return $this->container
			->get(MarkdownHelper::class)
			->parse($value);
	}

	/**
	 * Returns an array of service types required by such instances, optionally keyed by the service names used internally.
	 *
	 * For mandatory dependencies:
	 *
	 *  * array('logger' => 'Psr\Log\LoggerInterface') means the objects use the "logger" name
	 *    internally to fetch a service which must implement Psr\Log\LoggerInterface.
	 *  * array('loggers' => 'Psr\Log\LoggerInterface[]') means the objects use the "loggers" name
	 *    internally to fetch an iterable of Psr\Log\LoggerInterface instances.
	 *  * array('Psr\Log\LoggerInterface') is a shortcut for
	 *  * array('Psr\Log\LoggerInterface' => 'Psr\Log\LoggerInterface')
	 *
	 * otherwise:
	 *
	 *  * array('logger' => '?Psr\Log\LoggerInterface') denotes an optional dependency
	 *  * array('loggers' => '?Psr\Log\LoggerInterface[]') denotes an optional iterable dependency
	 *  * array('?Psr\Log\LoggerInterface') is a shortcut for
	 *  * array('Psr\Log\LoggerInterface' => '?Psr\Log\LoggerInterface')
	 *
	 * @return array The required service types, optionally keyed by service names
	 */
	public static function getSubscribedServices()
	{
		return [
			MarkdownHelper::class,
		];
	}
}
