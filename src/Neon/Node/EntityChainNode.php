<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */

declare(strict_types=1);

namespace Nette\Neon\Node;

use Nette\Neon;
use Nette\Neon\Node;


/** @internal */
final class EntityChainNode extends Node
{
	/** @var EntityNode[] */
	public $chain = [];


	public function __construct(array $chain = [])
	{
		$this->chain = $chain;
	}


	public function toValue(callable $evaluator = null): Neon\Entity
	{
		$entities = [];
		foreach ($this->chain as $item) {
			$entities[] = $evaluator ? $evaluator($item) : $item->toValue();
		}

		return new Neon\Entity(Neon\Neon::Chain, $entities);
	}


	public function toString(callable $serializer = null): string
	{
		return implode('', array_map(function ($entity) use ($serializer) {
			return $serializer ? $serializer($entity) : $entity->toString();
		}, $this->chain));
	}


	public function &getIterator(): \Generator
	{
		foreach ($this->chain as &$item) {
			yield $item;
		}
	}
}
