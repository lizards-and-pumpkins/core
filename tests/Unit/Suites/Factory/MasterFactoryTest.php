<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Core\Factory;

use LizardsAndPumpkins\Core\Factory\Exception\FactoryAlreadyRegisteredException;
use LizardsAndPumpkins\Core\Factory\Exception\UndefinedFactoryMethodException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LizardsAndPumpkins\Core\Factory\MasterFactoryTrait
 * @uses   \LizardsAndPumpkins\Core\Factory\FactoryTrait
 */
class MasterFactoryTest extends TestCase
{
    /**
     * @var MasterFactory
     */
    private $dummyMasterFactory;

    protected function setUp(): void
    {
        $this->dummyMasterFactory = new class() implements MasterFactory {
            use MasterFactoryTrait;
        };
        $this->dummyMasterFactory->register(new StubFactory);
    }

    public function testExceptionIsThrownDuringAttemptToCallNotRegisteredFactoryMethod()
    {
        $this->expectException(UndefinedFactoryMethodException::class);
        $this->dummyMasterFactory->nonRegisteredMethod();
    }

    public function testRegisteredFactoryMethodsCanBeCalled()
    {
        $parameter = 'foo';
        $result = $this->dummyMasterFactory->createSomething($parameter);

        $this->assertSame($parameter, $result);
    }

    public function testHasReturnsIfMethodIsKnownOrNot()
    {
        $dummyFactory = new class implements Factory
        {
            use FactoryTrait;

            public function createFoo() { }
        };
        $this->dummyMasterFactory->register($dummyFactory);
        $this->assertTrue($this->dummyMasterFactory->hasMethod('createFoo'));
        $this->assertFalse($this->dummyMasterFactory->hasMethod('createBar'));
    }

    public function testCallsFactoryCallbackMethods()
    {
        $factoryWithCallbacks = new class implements FactoryWithCallback
        {
            use FactoryWithCallbackTrait;
            
            public $beforeFactoryRegistrationCallbackWasCalled = false;
            public $factoryRegistrationCallbackWasCalled = false;

            public function beforeFactoryRegistrationCallback(MasterFactory $masterFactory): void
            {
                $this->beforeFactoryRegistrationCallbackWasCalled = true;
            }

            public function factoryRegistrationCallback(MasterFactory $masterFactory): void
            {
                $this->factoryRegistrationCallbackWasCalled = true;
            }
        };
        $this->dummyMasterFactory->register($factoryWithCallbacks);
        $this->assertTrue($factoryWithCallbacks->beforeFactoryRegistrationCallbackWasCalled);
        $this->assertTrue($factoryWithCallbacks->factoryRegistrationCallbackWasCalled);
    }

    public function testThrowsAnExceptionIfFactoryHasBeenAlreadyRegistered()
    {
        $this->expectException(FactoryAlreadyRegisteredException::class);

        $this->dummyMasterFactory->register(new StubFactory());
        $this->dummyMasterFactory->register(new StubFactory());
    }
}
