<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Core\Factory;

interface FactoryWithCallback extends Factory
{
    public function factoryRegistrationCallback(MasterFactory $masterFactory): void;

    public function beforeFactoryRegistrationCallback(MasterFactory $masterFactory): void;
}
