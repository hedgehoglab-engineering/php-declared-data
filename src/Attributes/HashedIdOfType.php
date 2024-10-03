<?php

namespace HedgehoglabEngineering\LaravelDataTools\Attributes;

enum HashedIdOfType: string
{
    case FQCN = 'fqcn';
    case MORPH = 'morph';
}
