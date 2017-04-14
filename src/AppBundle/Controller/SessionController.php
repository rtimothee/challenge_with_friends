<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Session;
use Doctrine\ORM\Query;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Session controller.
 *
 * @Route("session")
 */
class SessionController extends Controller
{
    /**
     * Creates a new session entity.
     *
     * @Route("/new", name="session_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $session = new Session();

        $rep = $this->getDoctrine()->getRepository('AppBundle:Challenge');
        $all_challenges = $rep->findAll(Query::HYDRATE_ARRAY);
        shuffle($all_challenges);

        $session->setChallenge($all_challenges[0]);
        $session->setUser($this->get('security.token_storage')->getToken()->getUser());


        $form = $this->createForm('AppBundle\Form\SessionType', $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($session);
            $em->flush();

            $this->sendMail($session);

            return $this->redirectToRoute('homepage', array('id' => $session->getId()));
        }

        return $this->render('session/new.html.twig', array(
            'session' => $session,
            'form' => $form->createView(),
            'challenge' => $all_challenges[0]
        ));
    }

    /**
     * @param Session $current
     */
    private function sendMail(Session $current){
        //all users
        $rep = $this->getDoctrine()->getRepository('AppBundle:User');
        $users = $rep->findAll();

        // init send mail
        $mailer = $this->get('mailer');
        $sender_email = $current->getUser()->getEmail();
        $sender_name = $current->getUser()->getUsername();

        //send mail for all users
        foreach ($users as $u){
            $message = \Swift_Message::newInstance()
                ->setSubject('Un nouveau Challenge est tombé !')
                ->setFrom(array($sender_email => $sender_name))
                ->setTo(array($u->getEmail() =>$u->getUsername()))
                ->setBody(
                    $this->renderView(
                        'Emails/challenge.html.twig',
                        array(
                            'name' => $u->getUsername(),
                            'current' => $current
                        )
                    ),
                    'text/html'
                )
            ;
            
            try {
                $mailer->send($message);
            } catch (\Exception $e){
                dump($e->getMessage());
            }
        }

    }
}
