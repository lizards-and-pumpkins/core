<?php

declare(strict_types = 1);

namespace LizardsAndPumpkins\Core\Factory;

use LizardsAndPumpkins\Core\Factory\Exception\NoMasterFactorySetException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LizardsAndPumpkins\Core\Factory\FactoryTrait
 */
class FactoryTraitTest extends TestCase
{
    public function createMasterFactorySpyFactory(): Factory
    {
        return new class implements Factory {
            use FactoryTrait;

            public function spyOnMasterFactory(): MasterFactory
            {
                return $this->getMasterFactory();
            }
        };
    }
    
    public function testMasterFactoryCanBeSetAndReturned(): void
    {
        $factory = $this->createMasterFactorySpyFactory();

        /** @var MasterFactory $dummyMasterFactory */
        $dummyMasterFactory = $this->createMock(MasterFactory::class);
        
        $factory->setMasterFactory($dummyMasterFactory);
        $this->assertSame($dummyMasterFactory, $factory->spyOnMasterFactory());
    }

    public function testThrowsExceptionIfNoMasterFactoryIsSet(): void
    {
        $this->expectException(NoMasterFactorySetException::class);
        $this->expectExceptionMessage('No master factory set');

        $factory = $this->createMasterFactorySpyFactory();
        $factory->spyOnMasterFactory();
    }
}
