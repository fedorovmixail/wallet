<?php

namespace Wallet\Services;

use Aura\Filter\FilterFactory;

class ValidatorService
{
    private array $messages = [];
    private FilterFactory $factory;

    public function __construct(FilterFactory $factory)
    {
        $this->factory = $factory;
    }

    public function validate(string $validatorClassName, array $values): bool
    {
        $entity_filter = $this->factory->newSubjectFilter($validatorClassName);
        $success = $entity_filter->apply($values);
        //todo немного криво отдаются массивы в сообщниях
        $this->messages = $entity_filter->getFailures()->getMessages();

        return $success;
    }

    public function getMessages(): array
    {
        return $this->messages;
    }
}