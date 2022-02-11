<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
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
                    ManagerRegistry $doctrine, 
    				LoggerInterface $logger,
				    ChatterInterface $chatter,
				    MailerInterface $mailer
                ): 
				JsonResponse
    {
        $a = '';
        $em = $doctrine->getManager();
	
	
        $messages = $em->getRepository(Message::class)->findBy(
            ['Status' => 0],
        );

        $now = new DateTime();

        $json = [];

        foreach ($messages as $message) {
            if ($now >= $message->getEmissionDate()) {
                $json[] = ['id' => $message->getId()];
                $message->setSendingDate(new \DateTime('now'));

                switch ($message->getChoice()) {
                    case 'slack':
                            $messageSlack = (new ChatMessage($message->getTitle().' - '.$message->getBody()))
                                ->transport('slack');
                            $sentMessage = $chatter->send($messageSlack);
                            $message->setStatus(true);
                        break;
                    case 'email':
                            $email = (new Email())
                                ->from('symfony5@ddev.site')
                                ->to('no-reply@ddev.site')
                                ->subject($message->getTitre())
                                ->text($message->getBody())
                                ->html($message->getBody());
                            $mailer->send($email);
                            $message->setStatus(true);
                        break;
                    default:
                        break;
                }

                $em->persist($message);
                $em->flush();
            }
        }

        $response = new JsonResponse();

        $response->setData($json);
	
        return $response;

    }


}
