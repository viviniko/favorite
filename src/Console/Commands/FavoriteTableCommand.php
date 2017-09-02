<?php

namespace Viviniko\Favorite\Console\Commands;

use Viviniko\Support\Console\CreateMigrationCommand;

class FavoriteTableCommand extends CreateMigrationCommand
{
    /**
     * @var string
     */
    protected $name = 'favorite:table';

    /**
     * @var string
     */
    protected $description = 'Create a migration for the favorite service table';

    /**
     * @var string
     */
    protected $stub = __DIR__.'/stubs/favorite.stub';

    /**
     * @var string
     */
    protected $migration = 'create_favorite_table';
}
