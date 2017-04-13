<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $rep = $this->getDoctrine()->getRepository('AppBundle:Session');
        $query = $rep->createQueryBuilder('s')
            ->where('s.dateEnd > :date')
            ->setParameter('date', new \DateTime())
            ->getQuery();

        $current = $query->setMaxResults(1)->getOneOrNullResult();


        return $this->render('default/index.html.twig', [
            'current' => $current,
        ]);
    }
}
