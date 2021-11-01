<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */

declare(strict_types=1);

namespace Nette\Neon\Node;

use Nette\Neon\Entity;
use Nette\Neon\Node;


/** @internal */
final class EntityNode extends Node
{
	/** @var Node */
	public $value;

	/** @var ArrayItemNode[] */
	public $attributes;


	public function __construct(Node $value, array $attributes = [])
	{
		$this->value = $value;
		$this->attributes = $attributes;
	}


	public function toValue(callable $evaluator = null): Entity
	{
		return new Entity(
			$evaluator ? $evaluator($this->value) : $this->value->toValue(),
			ArrayItemNode::itemsToArray($this->attributes, $evaluator)
		);
	}


	public function toString(callable $serializer = null): string
	{
		return ($serializer ? $serializer($this->value) : $this->value->toString())
			. '('
			. ($this->attributes ? ArrayItemNode::itemsToInlineString($this->attributes, $serializer) : '')
			. ')';
	}


	public function &getIterator(): \Generator
	{
		yield $this->value;

		foreach ($this->attributes as &$item) {
			yield $item;
		}
	}
}
