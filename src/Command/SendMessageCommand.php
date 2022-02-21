<?php

namespace App\Command;

use App\Service\CronService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SendMessageCommand extends Command
{
    protected static $defaultName = 'message:send';
    protected static $defaultDescription = 'lancer le cron des massages';
    /**
     * @var CronService
     */
    private $cronService;

    /**
     * @param string|null $name
     * @param CronService $cronService
     */
    public function __construct(string $name = null,
                                CronService $cronService)
    {
        parent::__construct($name);
        $this->cronService = $cronService;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $nb = $this->cronService->sendMessage();
        $io->success('messages envoyés '.$nb);
        return Command::SUCCESS;
    }
}
