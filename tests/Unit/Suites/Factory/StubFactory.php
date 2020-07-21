<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Core\Factory;

class StubFactory implements Factory
{
    /**
     * @var MasterFactory
     */
    private $masterFactory;

    public function setMasterFactory(MasterFactory $masterFactory): void
    {
        $this->masterFactory = $masterFactory;
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
