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

    const USERS_INDEX = 'users-index';
    const USERS_CREATE = 'users-create';
    const USERS_UPDATE = 'users-update';
    const USERS_DELETE = 'users-delete';

    const ADMINS_INDEX = 'admins-index';
    const ADMINS_CREATE = 'admins-create';
    const ADMINS_UPDATE = 'admins-update';
    const ADMINS_DELETE = 'admins-delete';

    const STREAMS_DELETE = 'streams-delete';
}
