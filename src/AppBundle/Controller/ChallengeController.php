<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Challenge;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Challenge controller.
 *
 * @Route("challenge")
 */
class ChallengeController extends Controller
{

    /**
     * Creates a new challenge entity.
     *
     * @Route("/new", name="challenge_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $challenge = new Challenge();
        $challenge->setUser($this->get('security.token_storage')->getToken()->getUser());
        $challenge->setCreated(new \DateTime());
        $form = $this->createForm('AppBundle\Form\ChallengeType', $challenge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($challenge);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('challenge/new.html.twig', array(
            'challenge' => $challenge,
            'form' => $form->createView(),
        ));
    }

}
