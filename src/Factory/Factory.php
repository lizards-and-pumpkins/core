<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Core\Factory;

interface Factory
{
    public function setMasterFactory(MasterFactory $masterFactory): void;
}
