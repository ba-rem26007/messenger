<?php

namespace App\Service;

use App\Repository\MessageRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;
use Symfony\Component\Notifier\Message\ChatMessage;

class CronService{

    /**
     * @var ChatterInterface
     */
    private $chatter;
    /**
     * @var MailerInterface
     */
    private $mailer;
    /**
     * @var MessageRepository
     */
    private $messageRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var array
     */
    private $log = array();

    /**
     * @param MessageRepository $messageRepository
     * @param EntityManagerInterface $entityManager
     * @param ChatterInterface $chatter
     * @param MailerInterface $mailer
     */
    public function __construct(MessageRepository $messageRepository,
                                EntityManagerInterface $entityManager,
                                ChatterInterface $chatter,
                                MailerInterface  $mailer)
    {
        $this->chatter = $chatter;
        $this->mailer = $mailer;
        $this->messageRepository = $messageRepository;
        $this->entityManager = $entityManager;
    }

    public function sendMessage(){
        $nb = 0;
        $messages = $this->messageRepository->findMessageToSend();
        foreach ($messages as $message) {
            // $this->addFlash('success', 'Message send '.$message->getChoice());
            $method = $message->getChoice();
            //{"$method}
            if ($method=='slack') { //method_exists($this->slack)){
                $send = $this->slack($message);
            }
            else{
                $send = $this->mail($message);
            }
            if($send==1)$nb++;

            $this->log[$message->getId()] = $send;
            $this->entityManager->persist($message);
            $this->entityManager->flush();
        }
        return $nb;
    }


    private function slack($message){
        //$options = (new SlackOptions());
        $messageSlack = (new ChatMessage($message->getTitle() .' - '. $message->getBody()  )  )
            ->transport('slack');
        //$recap = "<li>Slack : ".$message->getTitle() .' - '. $message->getBody()."</li>";
        //Add the custom options to the chat message and send the message
        //$chatter->options($options);
        try {
            $sentMessage = $this->chatter->send($messageSlack);
            if($sentMessage!==FALSE){
                $message->setSendingDate(new \DateTime('now'));
                $message->setStatus(true);
                return(true);
            }
        } catch (TransportExceptionInterface $e) {
            return(false);
        }

        return($message);
    }

    private function mail($message)
    {
        $email = (new Email())
            ->from('symfony5@ddev.site')
            ->to('no-reply@ddev.site')
            ->subject($message->getTitre())
            ->text($message->getBody())
            ->html($message->getBody());
        try {
            $this->mailer->send($email);
            $message->setSendingDate(new \DateTime('now'));
            $message->setStatus(true);
            return(true);
        } catch (\Symfony\Component\Mailer\Exception\TransportExceptionInterface $e) {
            return(false);
        }
    }




    /**
     * @return array
     */
    public function getLog(): array
    {
        return $this->log;
    }

    /**
     * @param array $log
     */
    public function setLog(array $log): void
    {
        $this->log = $log;
    }


}