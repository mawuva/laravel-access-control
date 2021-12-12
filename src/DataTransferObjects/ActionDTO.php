<?php

namespace Mawuekom\Accontrol\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class ActionDTO extends DataTransferObject
{
    public string $name;
    public string|null $slug;
    public string|null $description;
    public int|null $available_for_all_entities;
}