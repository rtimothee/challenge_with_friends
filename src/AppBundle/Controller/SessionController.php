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

            return $this->redirectToRoute('session_show', array('id' => $session->getId()));
        }

        return $this->render('session/new.html.twig', array(
            'session' => $session,
            'form' => $form->createView(),
        ));
    }
}
