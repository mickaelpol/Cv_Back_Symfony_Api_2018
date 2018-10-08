<?php

namespace UserBundle\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTDecodedListener
{
	/**
	 * @var RequestStack
	 */
	private $requestStack;

	/**
	 * @param RequestStack $requestStack
	 */
	public function __construct( RequestStack $requestStack ) {
		$this->requestStack = $requestStack;
	}

	/**
	 * @param JWTDecodedEvent $event
	 *
	 * @return void
	 */
	public function onJWTDecoded( JWTDecodedEvent $event)
	{
		$payload = $event->getPayload();

		if (!isset($payload['user_id']) || $payload['user_id'] !== $event->getUser()->getId()) {
			$event->markAsInvalid();
		}
	}
}