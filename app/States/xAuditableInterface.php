<?php

namespace App\Extensions;

interface AuditableInterface
{
    const CREATED_AT = 'creat';
    const UPDATED_AT = 'updat';
    const DELETED_AT = 'delat';
}
