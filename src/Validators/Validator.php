<?php

namespace Jsdecena\Payjunction\Validators;

use Illuminate\Validation;
use Illuminate\Filesystem;
use Illuminate\Translation;

class Validator
{
    /**
     * @return Validation\Factory
     */
    public static function make(): Validation\Factory
    {
        $filesystem = new Filesystem\Filesystem();
        $fileLoader = new Translation\FileLoader($filesystem, '');
        $translator = new Translation\Translator($fileLoader, 'en_US');
        return new Validation\Factory($translator);
    }
}
