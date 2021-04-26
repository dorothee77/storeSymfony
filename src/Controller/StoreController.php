<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class StoreController extends AbstractController
{
    /**
     * @Route("/store", name="store")
     */
    public function index(CategoryRepository $repo): Response
    {
        $category = $repo->findAll();
        return $this->render('store/index.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/store/prod", name="prod")
     */
    public function listProduit(ProductRepository $repo): Response
    {
        $product = $repo->findAll();
        return $this->render('store/product.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home() {
        return $this->render('store/home.html.twig', );    
    }

     /**
     * @Route("/store/{id}", name="detail_prod")
     */

     public function detailProduct(Product $product) {
        
        // Générer la vue
        // dump($product);
        // naissance de l'objet produit
        // il y a dedant toutes les infos de la base de donnée
        // on va manipuler cet objet
        return $this->render('store/detail.html.twig', [
            'product' => $product,
        ]);
    } 

     /**
     * @Route("/store/category/{id}", name="detail_category")
     */

    public function detailCategory(Category $category) {
        
        // Générer la vue
        return $this->render('store/index.html.twig', [
            'category' => $category,
        ]); 
    }

     /**
     * @Route("/store/category/add/{id}", name="add_category")
     */
    public function addCategory(Category $category, EntityManagerInterface $manager, Request $requete){
        // initialisation de la category
        $category = new Category();
        
            
        // manager pour ecrire sur la base de donnée
        $form = $this->createForm(CategoryType::class, $category);
        // envoi les valeurs par le POST
        $form->handleRequest($requete);
        // Si le form est soumis et valide  envoi sur la base
        if ($form->isSubmitted() && $form->isValid()){
            // requet insert into en attente dans server de la base
            $manager->persist($category);
            // valide l'ecriture dans la base
            $manager->flush();
            return $this->redirectToRoute('detail_art',[
                'id' => $category->getId()
            ]);
        }
        // Si non génération de la page formulaire vide
        return $this->render('store/form_category.html.twig', [
                'formCategory' => $form->createView()
            ]);
    }
     /**
     * @Route("/store/deletecat/{category.id}", name="delete_cat")
     */
    public function deleteCategory(Category $category, EntityManagerInterface $manager) {
        //$manager = $this->getDoctrine()->getManager();

        $manager->remove($category);
        $manager->flush();
        return $this->redirectToRoute('store');    
    }
         /**
     * @Route("/store/{id}/deleteprod", name="delete_prod")
     */
    public function deleteProduct(Product $product, EntityManagerInterface $manager) {
        //$manager = $this->getDoctrine()->getManager();

        $manager->remove($product);
        $manager->flush();
        return $this->redirectToRoute('prod');    
    }

}
