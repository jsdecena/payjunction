<?php

namespace Jsdecena\Payjunction\Interfaces;

interface ServiceInterface
{
    public function transform(): array;

    public function toCollection(): array;
}
