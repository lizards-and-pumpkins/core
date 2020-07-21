<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Core\Factory;

use LizardsAndPumpkins\Core\Factory\Exception\NoMasterFactorySetException;

trait FactoryTrait
{
    /**
     * @var MasterFactory
     */
    private $masterFactory;

    final public function setMasterFactory(MasterFactory $masterFactory): void
    {
        $this->masterFactory = $masterFactory;
    }

    final protected function getMasterFactory() : MasterFactory
    {
        if ($this->masterFactory === null) {
            throw new NoMasterFactorySetException('No master factory set');
        }

        return $this->masterFactory;
    }
}
