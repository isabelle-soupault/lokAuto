<?php

namespace App\Controller;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController {
/**
* @Route("/", name="home")
    */
    public function index(): Response
    {
        return $this->render('home.html.twig');
    }

//    public function admin()
//    {
//        $this->denyAccessUnlessGranted('ROLE_ADMIN');
//        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
//
//        return $this->render('admin.html.twig', [
//            //'articles' => $articles,
//            'users' => $users
//        ]);


        //$articles = $this->getDoctrine()->getRepository(Article::class)->findBy(
        //    [],
        //    ['lastUpdateDate' => 'DESC']
        //);

}