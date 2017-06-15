<?php

namespace Birk\MyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Birk\MyBundle\Entity\User;
use Birk\MyBundle\Entity\Post;


class UserController extends Controller
{
    /**
     * @Route("/user")
     * name=user
     */
    public function userAllAction()
    {
        $doctrine=$this->getDoctrine();
        $repo = $doctrine->getRepository('BirkMyBundle:User');
        $allUser = $repo->findAll();

        $content = $this-> renderView('BirkMyBundle:Default:UserAll.html.twig',['user' =>$allUser]);

        return new Response($content);
    }

    /**
     * @Route("/user/{id}")
     * name="userone"
     * requirement={"id"="\d+"}
     */
    public function userOneAction($id=0)
    {
        if($id !==0){
            $doctrine=$this->getDoctrine();
            $repo = $doctrine->getRepository('BirkMyBundle:User');
            $user = $repo->find($id);

            $content = $this-> renderView('BirkMyBundle:Default:UserOne.html.twig',['user' =>$user]);

            return new Response($content);
        }else{
            return new Response('404');
        }
    }

    /**
     * @Route("/useradd")
     * name="useradd"
     */
    public function userAddAction(){
        $faker = \Faker\Factory::create('fr_BE');

        $user = new User();
        $user->setName($faker->name);
        $user->setPhoto($faker->imageUrl(300,300,'cats'));
        $user->setBio($faker->text(200));

        $post = new Post();
        $post->setTitle($faker->sentence(6));
        $post->setDescription($faker->text(300));

        $user->addPost($post);

        $doctrine = $this->getDoctrine();

        $em=$doctrine->getManager();
        $em->persist($user);
        $em->flush();

        $this->addFlash('notice','new user');

        return $this->redirectToRoute('birk_my_user_userall');

    }




}
