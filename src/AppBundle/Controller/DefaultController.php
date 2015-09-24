<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Post;
use AppBundle\Entity\Autor;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $nombre = $request->query->get('nombre'); // Para variables GET
        // $nombre = $request->request->get('nombre'); // Para variables POST

        return new Response('Hola '.$nombre);

        // replace this example code with whatever you need
        // return $this->render('default/index.html.twig', array(
        //     'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        // ));
    }

    /**
     * @Route("/bienvenida/{nombre}", name="bienvenida")
     * @Template()
     * @Method("GET")
     */
    public function bienvenidaAction($nombre)
    {
        return array(
            'nombre' => $nombre,
            );
        // return new Response("Bienvenido a la aplicacion " . $nombre );
    }

    /**
     * @Route("/crearpost", name="crearpost")
     * @Template()
     */
    public function crearpostAction()
    {
        $post = new Post();
        $post->setTitulo('Un segundo post');
        $post->setTexto('Este es un texto corto');

        $em = $this->getDoctrine()->getManager();

        $autor = $em->getRepository('AppBundle:Autor')->find(1);
        $post->setAutor($autor);

        $em->persist($post);
        $em->flush();

        return new Response();
    }

    /**
     * @Route("/actualizarpost", name="actualizarpost")
     * @Template()
     */
    public function actualizarpostAction()
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('AppBundle:Post')->find(2);

        $categorias = $em->getRepository('AppBundle:Categoria')->findAll();
        foreach ($categorias as $categoria)
            $post->addCategoria($categoria);

        $em->flush();

    }

    /**
     * @Route("/mostrarpost/{id}", name="mostrarpost")
     * @Template()
     */
    public function mostrarpostAction(Post $post)
    {
        return array('post'=>$post);
    }

    /**
     * @Route("/eliminarpost", name="eliminarpost")
     * @Template()
     */
    public function eliminarpostAction()
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('AppBundle:Post')->find(1);
        $em->remove($post);
        $em->flush();
        return new Response();

    }

    /**
     * @Route("/postsporautor/{id}", name="postsporautor")
     * @Template()
     */
    public function postsporautorAction(Autor $autor)
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->createQuery('SELECT p from AppBundle:Post p where p.autor = ?1 order by p.titulo asc')
                        ->setParameter(1, $autor)
                        ->getResult();
        return array('posts'=>$posts);
        
    }
}
