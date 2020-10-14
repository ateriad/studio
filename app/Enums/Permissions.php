<?php

namespace App\Enums;

class Permissions extends Enum
{
    const ASSET_CATEGORIES_INDEX = 'asset-categories-index';
    const ASSET_CATEGORIES_CREATE = 'asset-categories-create';
    const ASSET_CATEGORIES_UPDATE = 'asset-categories-update';
    const ASSET_CATEGORIES_DELETE = 'asset-categories-delete';

    const ASSETS_INDEX = 'assets-index';
    const ASSETS_CREATE = 'assets-create';
    const ASSETS_UPDATE = 'assets-update';
    const ASSETS_DELETE = 'assets-delete';
}
