<?php

declare(strict_types=1);

return [
    /* configuration for models generation */
    // filesystem path for directory were models will be generated, in application absolut path is recommended
    'model-output-path' => './app/Model/Database',
    'model-namespace' => 'App\\Model\\Database',
    // absolut path for templates used for model class rendering
    // if you do not like generated classes, you can change them because of your code style or whatever
    'model-template-path' => __DIR__.'/../../../vendor/simple-as-fuck/orm/src/Generator/Template/Model.php',
    'model-generated-template-path' => __DIR__.'/../../../vendor/simple-as-fuck/orm/src/Generator/Template/ModelGenerated.php',
    'model-result-template-path' => __DIR__.'/../../../vendor/simple-as-fuck/orm/src/Generator/Template/ModelResult.php',

    /* configuration for repositories generation */
    // filesystem path for directory were repositories will be generated, in application absolut path is recommended
    'repository-output-path' => './app/Service/Database',
    'repository-namespace' => 'App\\Service\\Database',
    // absolut path for templates used for repository class rendering
    // if you do not like generated classes, you can change them because of your code style or whatever
    'repository-template-path' => __DIR__.'/../../../vendor/simple-as-fuck/orm/src/Generator/Template/Repository.php',
    'repository-generated-template-path' => __DIR__.'/../../../vendor/simple-as-fuck/orm/src/Generator/Template/RepositoryGenerated.php',

    /* configuration for custom type generation */
    'custom-type-templates' => [
        // every not primitive type must have templates for small part of code rendering
        \DateTimeImmutable::class => [
            // read template render small code how is property read from custom type into database
            // mainly some getter called on instance of custom type
            'read' => __DIR__.'/../../../vendor/simple-as-fuck/orm/src/Generator/Template/DateTimeReadValue.php',
            // write template render how is custom type create from primitive type loaded from database
            // mainly call of constructor value object
            'write' => __DIR__.'/../../../vendor/simple-as-fuck/orm/src/Generator/Template/DateTimeImmutableWriteValue.php',
        ],
        \Carbon\CarbonImmutable::class => [
            'read' => __DIR__.'/../../../vendor/simple-as-fuck/orm/src/Generator/Template/DateTimeReadValue.php',
            'write' => __DIR__.'/../../Generator/Template/CarbonImmutableWriteValue.php',
        ],
        \Carbon\Carbon::class => [
            'read' => __DIR__.'/../../../vendor/simple-as-fuck/orm/src/Generator/Template/DateTimeReadValue.php',
            'write' => __DIR__.'/../../Generator/Template/CarbonWriteValue.php',
        ],
    ],

    /* configuration for connect into database for generator and for generated classes */
    // string with connection name if null default laravel connection used
    'database-connection' => null,

    /* configuration with loader is used for database driver */
    //  key is name of laravel database driver nad value is class name used in service provider
    'structure-loaders' => [
        'mysql' => \SimpleAsFuck\Orm\Generator\StructureLoader\Mysql::class
    ],

    /* configuration for structure loading from database */
    // if database type is not found in any map (type, column, table) string type is used as default
    // this map define how database types in all tables are converted into php types
    // key is database type, value is php type
    'database-type-map' => [
        'tinyint' => 'int',
        'smallint' => 'int',
        'mediumint' => 'int',
        'integer' => 'int',
        'int' => 'int',
        'bigint' => 'int',
        'decimal' => 'string',
        'float' => 'float',
        'double' => 'float',
        'char' => 'string',
        'varchar' => 'string',
        'binary' => 'string',
        'varbinary' => 'string',
        'blob' => 'string',
        'tinytext' => 'string',
        'text' => 'string',
        'mediumtext' => 'string',
        'longtext' => 'string',
        'datetime' => \Carbon\CarbonImmutable::class,
        'timestamp' => \Carbon\CarbonImmutable::class,
        'date' => \Carbon\CarbonImmutable::class,
        'time' => \Carbon\CarbonImmutable::class,
    ],
    // this map define how column name in all tables is converted into php type
    // key is database column name, value is php type
    'database-column-map' => [],
    // this map define how column name in specific tables is converted into php type
    // key is database table name and column name like this 'table.column', value is php type
    'database-table-map' => [],
    // array of table names ignored for class generation
    'database-ignored-tables' => [],
];
