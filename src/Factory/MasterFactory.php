<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Core\Factory;

interface MasterFactory
{
    public function register(Factory $factory): void;

    public function hasMethod(string $method): bool;
}
