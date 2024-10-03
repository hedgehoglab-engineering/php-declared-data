<?php

namespace HedgehoglabEngineering\LaravelDto\Attributes;

enum HashedIdOfType: string
{
    case FQCN = 'fqcn';
    case MORPH = 'morph';
}
