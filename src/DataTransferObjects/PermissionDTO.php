<?php

namespace Mawuekom\Accontrol\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class PermissionDTO extends DataTransferObject
{
    public string $name;
    public string|null $slug;
    public string|null $description;
}