<?php

namespace Application\Services;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class Doctrine{

    public $em = null;

    public function __construct($connectionOptions)
    {
        $paths = [
            rtrim(__DIR__ . "/../Repositories"),
            rtrim(__DIR__ . "/../Entities"),
        ];

        $isDevMode = true;

        $config = Setup::createAnnotationMetadataConfiguration($paths,$isDevMode,null,null,false);
        $this->em = EntityManager::create($connectionOptions,$config);

    }

}