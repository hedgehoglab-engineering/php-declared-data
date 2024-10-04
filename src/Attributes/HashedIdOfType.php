<?php

namespace HedgehoglabEngineering\DeclaredData\Attributes;

enum HashedIdOfType: string
{
    case FQCN = 'fqcn';
    case MORPH = 'morph';
}
