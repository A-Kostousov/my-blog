<?php
namespace App\Controller;
use App\Entity\Comments;
use App\Entity\Post;
use App\Form\CommentsType;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;;

class PublicationController extends AbstractController
{
    /**
     * @Route("/add-publication", name="add-publication")
     */
    public function post (Request $request, EntityManagerInterface $entityManager)
    {
        $post = new Post ();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($post);
            $entityManager->flush();
            $this->addFlash('success', 'Добавить публикацию');
            return $this->redirectToRoute('show', ['id' => $post->getId()]);
        }
        return $this->render('blog/new_post.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show (Post $post, Request $request, EntityManagerInterface $entityManager)
    {
        $comments = new Comments();
        $comments->setContent($post);
        $form = $this->createForm(CommentsType::class, $comments);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($comments);
            $entityManager->flush();
            $this->addFlash('success', 'Ваш комментарий успешно добавлен');
            return $this->redirectToRoute('show', [
                'id' => $post->getId()]);
        }
        return $this->render('blog/show.html.twig', [
            'post' => $post,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function update_post($id, Request $request)
    {
        $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($id);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("show", [
                'id' => $post->getId()]);
        }
        return $this->render('blog/update.html.twig',[
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete_post($id)
    {
        $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute("homepage");
    }
}