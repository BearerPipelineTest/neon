<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */

declare(strict_types=1);

namespace Nette\Neon;


/**
 * @implements \IteratorAggregate<Node>
 */
abstract class Node implements \IteratorAggregate
{
	/** @var ?int */
	public $startTokenPos;

	/** @var ?int */
	public $endTokenPos;

	/** @var ?int */
	public $startLine;

	/** @var ?int */
	public $endLine;


	/**
	 * @param  callable(self): mixed|null  $evaluator
	 * @return mixed
	 */
	abstract public function toValue(callable $evaluator = null);


	/** @param  callable(self): string|null  $serializer */
	abstract public function toString(callable $serializer = null): string;


	public function &getIterator(): \Generator
	{
		return;
		yield;
	}
}
