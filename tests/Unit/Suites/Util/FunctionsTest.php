<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Util;

use PHPUnit\Framework\TestCase;

/**
 * @covers \every
 * @covers \typeof
 * @covers \pipeline
 */
class FunctionsTest extends TestCase
{
    private static $callbackArguments = [];

    /**
     * @param mixed $value
     * @param string|int $index
     */
    public static function notifyCallback($value, $index): void
    {
        self::$callbackArguments[] = [$index, $value];
    }

    public function multiplyBy3(...$args)
    {
        return array_sum($args) * 3;
    }

    /**
     * @return array[]
     */
    private function getReceivedCallbackArguments() : array
    {
        return self::$callbackArguments;
    }

    protected function setUp(): void
    {
        self::$callbackArguments = [];
    }

    public function testEveryItemAndIndexIsPassedToTheCallback(): void
    {
        $sourceItems = [
            new \stdClass(),
            new \stdClass(),
        ];
        $receivedArguments = [];
        every($sourceItems, function ($item, $index) use (&$receivedArguments) {
            $receivedArguments[$index] = $item;
        });
        $this->assertSame($receivedArguments, $sourceItems);
    }

    public function testEveryWorksWithStringArrayIndexes(): void
    {
        $items = ['foo' => 'bar', 'baz' => 'qux'];
        $receivedIndexes = [];
        every($items, function ($item, $index) use (&$receivedIndexes) {
            $receivedIndexes[] = $index;
        });
        $this->assertSame(array_keys($items), $receivedIndexes);
    }

    public function testEveryWorksWithTraversable(): void
    {
        $array = ['foo', 'bar', 'baz'];
        $items = new \ArrayIterator($array);
        $receivedArguments = [];
        every($items, function ($item, $key) use (&$receivedArguments) {
            $receivedArguments[$key] = $item;
        });
        $this->assertSame($array, $receivedArguments);
    }

    public function testEveryWorksWithStringCallbacks(): void
    {
        $items = [111];
        every($items, '\LizardsAndPumpkins\Util\callback_function');
        $this->assertSame([[0, 111]], $this->getReceivedCallbackArguments());
    }

    public function testEveryWorksWithArrayCallbacks(): void
    {
        $items = [222];
        every($items, [self::class, 'notifyCallback']);
        $this->assertSame([[0, 222]], $this->getReceivedCallbackArguments());
    }

    /**
     * @param mixed $value
     * @param string $expected
     * @dataProvider typeofDataProvider
     */
    public function testTypeofReturnsExpectedStringRepresentationOfType($value, string $expected): void
    {
        $this->assertSame($expected, typeof($value));
    }

    /**
     * @return array[]
     */
    public function typeofDataProvider() : array
    {
        return [
            ['', 'string'],
            [null, 'NULL'],
            [1, 'integer'],
            [.1, 'double'],
            [[], 'array'],
            [fopen(__FILE__, 'r'), 'resource'],
            [$this, get_class($this)],
        ];
    }
}

/**
 * @param mixed $value
 * @param int|string $index
 */
function callback_function($value, $index)
{
    FunctionsTest::notifyCallback($value, $index);
}
