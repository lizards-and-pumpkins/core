<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Core\Factory;

class StubFactory implements Factory
{
    public function setMasterFactory(MasterFactory $masterFactory): void
    {

    }

    public function createSomething(string $parameter) : string
    {
        return $parameter;
    }

    public function getSomething(): void
    {

    }

    public function doSomething(): void
    {

    }

    protected function createSomethingProtected(): void
    {
        $this->getSomethingPrivate();
    }

    private function getSomethingPrivate(): void
    {

    }
}
