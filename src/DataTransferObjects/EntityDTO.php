<?php

namespace Mawuekom\Accontrol\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class EntityDTO extends DataTransferObject
{
    public string $name;
    public string|null $slug;
    public string|null $model;
    public string|null $description;
}