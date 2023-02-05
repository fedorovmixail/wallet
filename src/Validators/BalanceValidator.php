<?php

namespace Wallet\Validators;

use Aura\Filter\SubjectFilter;

class BalanceValidator  extends SubjectFilter
{
    protected function init()
    {
        $this->validate('wallet')->is('int')->asHardRule();
    }
}