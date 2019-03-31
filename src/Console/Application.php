<?php

namespace Wangjunasd\Ecc\Console;

use Symfony\Component\Console\Application as ConsoleApplication;
use Wangjunasd\Ecc\Console\Commands\GenerateKeyPairCommand;
use Wangjunasd\Ecc\Console\Commands\HexDecCommand;
use Wangjunasd\Ecc\Console\Commands\DecHexCommand;
use Wangjunasd\Ecc\Console\Commands\ParsePublicKeyCommand;
use Wangjunasd\Ecc\Console\Commands\ParsePrivateKeyCommand;
use Wangjunasd\Ecc\Console\Commands\GeneratePublicKeyCommand;
use Wangjunasd\Ecc\Console\Commands\ListCurvesCommand;
use Wangjunasd\Ecc\Console\Commands\DumpAsnCommand;

class Application extends ConsoleApplication
{

    /**
     * @return array|\Symfony\Component\Console\Command\Command[]
     */
    protected function getDefaultCommands()
    {
        $commands = parent::getDefaultCommands();

        $commands[] = new DumpAsnCommand();
        $commands[] = new GenerateKeyPairCommand();
        $commands[] = new GeneratePublicKeyCommand();
        $commands[] = new ListCurvesCommand();
        $commands[] = new ParsePrivateKeyCommand();
        $commands[] = new ParsePublicKeyCommand();
        $commands[] = new HexDecCommand();
        $commands[] = new DecHexCommand();

        return $commands;
    }
}
