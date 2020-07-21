<?php

declare(strict_types = 1);

namespace LizardsAndPumpkins\Core\Factory;

trait FactoryWithCallbackTrait
{
    use FactoryTrait;
    
    public function beforeFactoryRegistrationCallback(MasterFactory $masterFactory): void
    {
        // Hook method intentionally left empty
    }

    public function factoryRegistrationCallback(MasterFactory $masterFactory): void
    {
        // Hook method intentionally left empty
    }
}
