<?php

namespace App\Controller;

use App\Service\CronService;
use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Security\Core\Security;
//use Symfony\Component\Notifier\Bridge\Slack\SlackOptions;

/**
 * @Route("/message")
 */
class MessageController extends AbstractController
{
    /**
     * @Route("/", name="message_index", methods={"GET"})
     */
    public function index(MessageRepository $messageRepository): Response
    {
        return $this->render('message/index.html.twig', [
            'messages' => $messageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="message_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        $errors = $form->getErrors();

        try {
	        if ($form->isSubmitted() && $form->isValid()) {
                $message->setStatus(0);
	            $entityManager->persist($message);
	            $entityManager->flush();

		        $this->addFlash('success', 'Message sauvé.');
		    
	            return $this->redirectToRoute('message_index', [], Response::HTTP_SEE_OTHER);
	    }
	} catch (\Exception $e) {
            $this->addFlash('danger', 'Message cannot be saved.');

            throw $e;
        }
        return $this->renderForm('message/new.html.twig', [
            'message' => $message,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="message_show", methods={"GET"})
     */
    public function show(Message $message): Response
    {
        return $this->render('message/show.html.twig', [
            'message' => $message,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="message_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Message $message, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('message/edit.html.twig', [
            'message' => $message,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="message_delete", methods={"POST"})
     */
    public function delete(Request $request, Message $message, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $entityManager->remove($message);
            $entityManager->flush();
        }
        return $this->redirectToRoute('message_index', [], Response::HTTP_SEE_OTHER);
    }
    
    /**
     * @Route("/cron/go", name="message_cron", methods={"GET", "POST"})
     */
    public function cron(
        CronService $cronService,
                    MessageRepository $messageRepository
                ):
				Response
    {

        $nb = $cronService->sendMessage();
        //return $response;
        $recap = "";
        if($nb==1)$recap = $nb." message envoyé";
        elseif($nb>1)$recap = $nb." messages envoyés";

        return $this->render('message/index.html.twig', [
            'messages' => $messageRepository->findAll(),
            'recap' => $recap
        ]);
    }


}
