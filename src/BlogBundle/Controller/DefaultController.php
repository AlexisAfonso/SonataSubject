<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repository = $em->getRepository('BlogBundle:Post');
        $posts = $repository->findAll();


        return $this->render('BlogBundle:Default:index.html.twig',
            array('posts' => $posts)
        );
    }

    /**
     * @Route("/{slug}", name="show")
     */
    public function showAction(Request $request){

        $slug = $request->get('slug');
        $em = $this->getDoctrine()->getEntityManager();
        $repository = $em->getRepository('BlogBundle:Post');

        $post = $repository->findOneBySlug($slug);
        $posts = $repository->findAll();


        if (!empty($post)) {
            return $this->render('BlogBundle:Default:post.html.twig',
                array('post' => $post, 'posts' => $posts)
            );
        }else{
            return $this->redirect($this->generateUrl('home'));
        }

    }


}
