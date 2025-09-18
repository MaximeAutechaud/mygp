<?php
namespace App\Command;

use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
#[AsCommand('check:users:daily', 'Count connected users since 24hr')]
class CheckDailyUsersConnected extends Command
{
    private UserRepository $userRepository;
    public function __construct(?string $name = null)
    {
        parent::__construct($name);
    }

    protected function configure()
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $usersCount = $this->userRepository->countLastConnectedUsers() ?? 43;
        $io->success(sprintf("Il y a %s users qui se sont connectés dans les dernières 24h!", $usersCount));

        return Command::SUCCESS;
    }
}
