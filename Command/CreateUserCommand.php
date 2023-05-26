<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Add a short description for your command',
)]
class CreateUserCommand extends Command
{
    public function __construct(string $name = null, EntityManagerInterface $entityManager, UserPasswordHasherInterface $encode, UserRepository $userRepository){

        parent::__construct($name);
        $this->entityManager = $entityManager;
        $this->encode = $encode;
        $this->userRepository = $userRepository;
    }
    protected function configure(): void
    {
        $this
            ->addOption('email', 'em',InputArgument::REQUIRED, 'Email')
            ->addOption('password', 'pa', InputArgument::OPTIONAL, 'Password')
            ->addOption('isAdmin', '',InputArgument::OPTIONAL, 'Если установлено, пользователь создается как администратор', 0)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = $input->getOption('email');
        $password = $input->getOption('password');
        $isAdmin = $input->getOption('isAdmin');

        $io->title('Добавление нового пользователя');
        $io->text(['Введите информацию']);

        if (!$email)
        {
            $email = $io->ask('Введите Email');
        }

        if (!$password)
        {
            $password = $io->askHidden('Введите пароль');
        }

        if (!$isAdmin){
            $question = new Question('Администратор или нет? (1 или 0)', 0);
            $isAdmin = $io->askQuestion($question);
        }

        $isAdmin = boolval($isAdmin);

        try {
            $user = $this->createUser($email, $password, $isAdmin);
            $user->getId();
        } catch (RuntimeException $exception) {
            $io->comment($exception->getMessage());

            return Command::FAILURE;
        }

        $successMessage = sprintf('Пользователь добавлен!');

        $io->success($successMessage);

        return Command::SUCCESS;
    }
    /**
     * @param string $email
     * @param string $password
     * @param bool $isAdmin
     * @return User
     */
    private function createUser(string $email, string $password, bool $isAdmin): User
    {
        $existUser = $this->userRepository->findOneBy(['email' => $email]);

        if($existUser){
            throw new RuntimeException('Такой пользователь уже существует');
        }

        $user = new User();
        $user->setEmail($email);
        $user->setRoles([$isAdmin ? 'ROLE_ADMIN' : 'ROLE_USER']);

        $encoderPassword =$this->encode->hashPassword($user, $password);
        $user->setPassword($encoderPassword);

        $user->setIsVerified(true);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
