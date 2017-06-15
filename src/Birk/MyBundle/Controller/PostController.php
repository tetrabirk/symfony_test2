<?php

namespace Birk\MyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Birk\MyBundle\Entity\User;
use Birk\MyBundle\Entity\Post;
use Birk\MyBundle\Entity\Categorie;


class PostController extends Controller
{
    /**
     * @Route("/")
     * name=post
     */
    public function postAllAction()
    {
        $doctrine=$this->getDoctrine();
        $repo = $doctrine->getRepository('BirkMyBundle:Post');
        $allPost = $repo->findAll();

        $content = $this-> renderView('BirkMyBundle:Default:postAll.html.twig',['post' =>$allPost]);

        return new Response($content);
    }

    /**
     * @Route("/post/{id}")
     * name="postone"
     * requirement={"id"="\d+"}
     */
    public function postOneAction($id=0)
    {
        if($id !==0){
            $doctrine=$this->getDoctrine();
            $repo = $doctrine->getRepository('BirkMyBundle:Post');
            $post = $repo->find($id);

            $content = $this-> renderView('BirkMyBundle:Default:PostOne.html.twig',['post' =>$post]);

            return new Response($content);
        }else{
            return new Response('404');
        }
    }

    /**
     * @Route("/postadd")
     * name="postadd"
     */
    public function postAddAction(){
        $faker = \Faker\Factory::create('fr_BE');

        $post = new Post();
        $post->setTitle($faker->sentence(6));
        $post->setDescription($faker->text(300));

        $categ = new Categorie();
        $categ->setTitle($faker->sentence(2));

        $user = new User();
        $user->setName($faker->name);
        $user->setPhoto($faker->imageUrl(300,300,'cats'));
        $user->setBio($faker->text(200));

        $post->setUser($user);
        $post->setCategorie($categ);

        $doctrine = $this->getDoctrine();

        $em=$doctrine->getManager();
        $em->persist($post);
        $em->flush();

        $this->addFlash('notice','new post');

        return $this->redirectToRoute('birk_my_post_postall');

    }




}
