<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PostController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $posts = $entityManager->getRepository(Post::class)->sortByNewest();

        return $this->render('homepage.html.twig', [
            'posts' => $posts,
        ]);
    }
    #[Route('/post/create', name: 'post.create')]
    public function create():Response
    {
        return $this->render('post/create.html.twig');
    }

    #[Route('/post/submit', name: 'post.submit')]
    public function submit(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST'))
        {
            $title = $request->request->get('title');
            $content = $request->request->get('content');

            $post = new Post();
            $post->setTitle($title);
            $post->setContent($content);
            //dd($post);
            $entityManager->persist($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('homepage');

    }

    #[Route('/post/{id}', name: 'post.show')]
    public function show($id, EntityManagerInterface $entityManager): Response
    {
        $post = $entityManager->getRepository(Post::class)->find($id);
        if ($post == null)
        {
            return $this->redirectToRoute('homepage');
        }

        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }


}
