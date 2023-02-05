<?php

namespace Wallet\Validators;

use Aura\Filter\SubjectFilter;
use Wallet\Models\Currency;
use Wallet\Services\BalanceUpdater\UpdateStrategies\UpdateStrategyFactory;

class FillValidator extends SubjectFilter
{
    protected function init()
    {
        $this->validate('wallet_id')->is('int')->asHardRule();
        $this->validate('type')->is('inValues', UpdateStrategyFactory::UPDATE_STRATEGIES)->asHardRule();
        $this->validate('amount')->is('float')->asHardRule();
        $this->validate('currency')->is('inValues', Currency::CURRENCY_LIST)->asHardRule();
        $this->validate('reason')->is('inValues', REASONS_LIST)->asHardRule();
    }
}