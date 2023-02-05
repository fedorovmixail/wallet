<?php

namespace Wallet\Validators;

use Aura\Filter\SubjectFilter;
use Wallet\Models\History;

class LastValidator  extends SubjectFilter
{
    protected function init()
    {
        $this->validate('lastDays')->is('int')->asHardRule();
        $this->validate('reason')->is('inValues', History::REASONS_LIST)->asHardRule();
    }
}