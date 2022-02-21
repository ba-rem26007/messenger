<?php

namespace App\Controller;

use App\Service\CronService;
use DateTime;
use App\Entity\Message;
use App\Repository\MessageRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Notifier\Bridge\Slack\SlackOptions;

/**
 * @Route("/cron")
 */
class CronController extends AbstractController
{
    /**
     * @Route("/", name="cron_go", methods={"GET", "POST"})
     */
    public function cron(
		            CronService $cronService
                    //Security $security
                ): 
				JsonResponse
    {

        $nb = $cronService->sendMessage();
        return(new JsonResponse($cronService->getLog()));
    }

}
