<?php
/*
 * This file is part of prooph/proophessor.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 9/5/15 - 10:10 PM
 */
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Setup autoloading
require 'vendor/autoload.php';

$container = require 'config/container.php';

/** @var \Doctrine\ORM\EntityManager $em */
$em = $container->get('doctrine.entitymanager.orm_default');

$cli = new \Symfony\Component\Console\Application('Doctrine Command Line Interface', \Doctrine\DBAL\Migrations\MigrationsVersion::VERSION());

$helperSet = new \Symfony\Component\Console\Helper\HelperSet();

$helperSet->set(new \Symfony\Component\Console\Helper\QuestionHelper(), 'dialog');

$helperSet->set(
    new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper(
        $em
    ),
    'em'
);

$helperSet->set(
    new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper(
        $em->getConnection()
    ),
    'connection'
);

$cli->setCatchExceptions(true);
$cli->setHelperSet($helperSet);

$cli->addCommands(array(
    // Migrations Commands
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\LatestCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand()
));

$cli->run();





