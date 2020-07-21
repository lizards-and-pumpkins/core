<?php

declare(strict_types = 1);

namespace LizardsAndPumpkins\Core\Factory;

use PHPUnit\Framework\TestCase;

/**
 * @covers \LizardsAndPumpkins\Core\Factory\FactoryWithCallbackTrait
 */
class FactoryWithCallbackTraitTest extends TestCase
{
    public function testCallbackMethodsCanBeCalledFromPublicScope(): void
    {
        $factoryWithCallback = new class implements FactoryWithCallback
        {
            use FactoryWithCallbackTrait;
        };

        $dummyMasterFactory = new class implements MasterFactory {
          use MasterFactoryTrait;  
        };
        
        $this->assertTrue(method_exists($factoryWithCallback, 'beforeFactoryRegistrationCallback'));
        $this->assertTrue(method_exists($factoryWithCallback, 'factoryRegistrationCallback'));
     
        $factoryWithCallback->beforeFactoryRegistrationCallback($dummyMasterFactory);
        $factoryWithCallback->factoryRegistrationCallback($dummyMasterFactory);
    }
}
