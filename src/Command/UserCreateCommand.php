<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCreateCommand extends Command
{
    protected static $defaultName = 'user:create';
    protected static $defaultDescription = 'permet de créer un utilisateur';

    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $hasher;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $hasher
    )
    {
        $this->entityManager = $entityManager;
        $this->hasher = $hasher;
        parent::__construct();
    }


    // Pour avoir des arguments : exemples : type de user ou login ...
    protected function configure(): void
    {
        /*
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
        */
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /*
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }
        */

        
        //QUESTIONS ....
        $helper = $this->getHelper('question');
        
        $question = new Question("identifiant (email) : ");
        $email = $helper->ask($input,$output,$question);
        $io->success('email donné : '.$email);

        $question2 = new Question("Password : ");
        $password = $helper->ask($input,$output,$question2);
        $io->success('Password : '.$password);

        $prenom  = $helper->ask($input, $output, new Question("Prénom : "));         
        $nom   = $helper->ask($input, $output, new Question("Nom : "));         
        

        //dump("DUMP EMAIL" . $email);

        // PHASE DE VERIFICATION

        if($email !== NULL && 
            $password !== NULL){

            $user = new User();
            $user->setEmail($email);
            $user->setPrenom($prenom)->setNom($nom);
            
            $pass_hash = $this->hasher->hashPassword($user, $password);
            
            $user->setPassword($pass_hash);
            
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $io->success('User crée avec succès !');
            return Command::SUCCESS;
    
        }
        else{

            $io->error('un des param est vide. ');
    
            return Command::FAILURE;
    
        }


        // 




    }
}
