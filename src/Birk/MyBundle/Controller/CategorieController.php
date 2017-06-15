<?php

namespace Birk\MyBundle\Controller;

use Birk\MyBundle\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Birk\MyBundle\Entity\User;
use Birk\MyBundle\Entity\Post;


class CategorieController extends Controller
{
    /**
     * @Route("/categ")
     * name="categall"
     */
    public function categAllAction()
    {
        $doctrine=$this->getDoctrine();
        $repo = $doctrine->getRepository('BirkMyBundle:Categorie');
        $allCateg = $repo->findAll();

        $content = $this-> renderView('BirkMyBundle:Default:categAll.html.twig',['post' =>$allCateg]);

        return new Response($content);
    }


    /**
     * @Route("/categadd")
     * name="categadd"
     */
    public function postAddAction(){
        $faker = \Faker\Factory::create('fr_BE');

        $categ = new Categorie();
        $categ->setTitle($faker->sentence(2));


        $doctrine = $this->getDoctrine();

        $em=$doctrine->getManager();
        $em->persist($post);
        $em->flush();

        $this->addFlash('notice','new categ');

        return $this->redirectToRoute("birk_my_categorie_categall");

    }




}
