<?php

namespace App\Controller;

use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Author;

class AuthorController extends AbstractController
{
    #[Route('/author/{name}', name: 'app_author')]
    public function showAuthor($name): Response
    {
        return $this->render('author/show.html.twig', [
            'name' => "$name"
        ]);
    }

    #[Route('/list', name: 'app_author')]
    public function list(): Response
    {
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
            'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
            ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' =>
            'taha.hussein@gmail.com', 'nb_books' => 300),
            );

            return $this->render('author/list.html.twig', [
                'authors' => $authors
            ]);
    }
    #[Route('/auhtorDetails/{id}', name: 'auhtorDetails')]
    public function auhtorDetails($id):Response
    {
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
            'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
            ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' =>
            'taha.hussein@gmail.com', 'nb_books' => 300),
            );

        return $this->render('author/showAuthor.html.twig', [
            'id' => $id,
            'authors' => $authors,
        ]);
    }

    

    #[Route('/show/{id}', name: 'show')]
    public function showaut($id, AuthorRepository $repo){
        $author=$repo->find($id);
        return $this->render('author/showone.html.twig', ['author'=>$author]);
    }
    #[Route('/delete/{id}', name: 'delete')]
    public function deleteauthor($id, AuthorRepository $repo, ManagerRegistry $manager){
        $author=$repo->find($id);
        $em = $manager->getManager();
        $em->remove($author);

        $em->flush();

        return $this->redirectToRoute('listAuteurs');


    }

    #[Route('/addstatic', name: 'addstatic')]

    public function addstatic ( ManagerRegistry $manager){
        $author= new Author();
        $author->setUsername('test');
        $author->setEmail('foulen@gmail.com');


        $em=$manager->getManager();
        $em->persist($author);
        $em->flush();

        return $this->redirectToRoute('listAuteurs');
    }

    #[Route('/add', name: 'add')]

    public function add ( Request $request, ManagerRegistry $manager){

        $author=new Author();
        $form=$this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            $em=$manager->getManager();
            $em->persist($author);
            $em->flush();

            return $this->redirectToRoute('listAuteurs');
        }

        return $this->render('author/add.html.twig',['formulaire'=>$form->createView()]);
    }

    #[Route('/upate/{id}', name: 'update')]

    public function update($id,Request $request, AuthorRepository $repo, ManagerRegistry $manager){
        $author=$repo->find($id);
        $form=$this->createForm(AuthorType::class,$author);
        $form->handleRequest($request);

        if($form->isSubmitted()){

            $em=$manager->getManager();
            $em->persist($author);
            $em->flush();

            return $this->redirectToRoute('listAuteurs');
        }

        return $this->render('author/update.html.twig',['form'=>$form->createView()]);

    }




    #[Route('/listA', name: 'listAuteurs')]
    public function ListAuteurs(AuthorRepository $repo):Response
    {
        $list = $repo->findAll();
        return $this->render('author/listA.html.twig', [ 'authors'=>$list]);
    }

}
