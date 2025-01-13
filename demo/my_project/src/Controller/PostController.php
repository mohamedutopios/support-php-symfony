<?php
// Définition du namespace pour le contrôleur
namespace App\Controller;

// Importation des classes nécessaires à partir du framework et de l'application
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;

// Déclaration du contrôleur qui étend AbstractController pour bénéficier de ses fonctionnalités
class PostController extends AbstractController
{
    // Méthode privée pour initialiser les données dans la session
    private function initializeData(Request $request): void
    {
        // Accès à l'objet session à partir de l'objet requête
        $session = $request->getSession();

        // Vérification si les 'posts' sont déjà initialisés dans la session
        if (!$session->has('posts')) {
            // Création et initialisation des posts si non présents
            $posts = [
                1 => new Post(1, 'Post 1', 'This is the first post.', new \DateTime('-2 days')),
                2 => new Post(2, 'Post 2', 'This is the second post.', new \DateTime('-1 days')),
            ];
            // Sauvegarde des posts dans la session
            $session->set('posts', $posts);
        }
    }

    // Route pour accéder à l'index des posts, méthode GET par défaut
    #[Route("/post", name: "post_index")]
    public function index(Request $request): Response
    {
        // Initialisation des données
        $this->initializeData($request);

        // Récupération de l'objet session
        $session = $request->getSession();
        // Récupération des posts de la session
        $posts = $session->get('posts');

        // Rendu de la vue index.html.twig avec les posts en tant que variable
        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    // Route pour voir un post spécifique, avec validation que l'id est numérique
    #[Route("/post/{id}", name: "post_show", requirements: ["id" => "\d+"])]
    public function show(Request $request, int $id): Response
    {
        // Assurez-vous que les données sont initialisées
        $this->initializeData($request);

        // Accès à la session et récupération des posts
        $session = $request->getSession();
        $posts = $session->get('posts', []);

        // Tentative de récupération du post spécifique par son id
        $post = $posts[$id] ?? null;

        // Si le post n'existe pas, lance une exception de non trouvé
        if (!$post) {
            throw $this->createNotFoundException(sprintf('The post with ID %d was not found.', $id));
        }

        // Rendu de la vue show.html.twig pour afficher le post
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    // Route pour la création d'un post via un formulaire
    #[Route("/post/create", name: "post_create")]
    public function create(Request $request): Response
    {
        // Initialisation des données
        $this->initializeData($request);

        // Récupération de la session
        $session = $request->getSession();

        // Traitement du formulaire si la méthode est POST
        if ($request->isMethod('POST')) {
            // Récupération des valeurs du formulaire
            $title = $request->request->get('title');
            $content = $request->request->get('content');

            // Récupération et mise à jour des posts
            $posts = $session->get('posts', []);
            $newId = count($posts) + 1;
            $newPost = new Post($newId, $title, $content, new \DateTime());

            // Ajout du nouveau post à la session
            $posts[$newId] = $newPost;
            $session->set('posts', $posts);

            // Redirection vers l'index des posts
            return $this->redirectToRoute('post_index');
        }

        // Rendu de la vue create.html.twig pour afficher le formulaire de création
        return $this->render('post/create.html.twig');
    }

    // Route pour éditer un post spécifique
    #[Route("/post/{id}/edit", name: "post_edit")]
    public function edit(Request $request, int $id): Response
    {
        // Assurez-vous que les données sont initialisées
        $this->initializeData($request);

        // Accès à la session et aux posts
        $session = $request->getSession();
        $posts = $session->get('posts', []);

        // Récupération du post à éditer
        $post = $posts[$id] ?? null;

        // Gestion de l'absence du post
        if (!$post) {
            throw $this->createNotFoundException('Post not found');
        }

        // Traitement de la soumission du formulaire
        if ($request->isMethod('POST')) {
            // Mise à jour des informations du post
            $post->title = $request->request->get('title');
            $post->content = $request->request->get('content');

            // Sauvegarde du post modifié dans la session
            $posts[$id] = $post;
            $session->set('posts', $posts);

            // Redirection vers l'index des posts
            return $this->redirectToRoute('post_index');
        }

        // Rendu de la vue edit.html.twig pour l'édition du post
        return $this->render('post/edit.html.twig', [
            'post' => $post,
        ]);
    }

    // Route pour supprimer un post spécifique
    #[Route("/post/{id}/delete", name: "post_delete")]
    public function delete(Request $request, int $id): Response
    {
        // Assurez-vous que les données sont initialisées
        $this->initializeData($request);

        // Accès à la session et récupération des posts
        $session = $request->getSession();
        $posts = $session->get('posts', []);

        // Suppression du post si présent
        if (isset($posts[$id])) {
            unset($posts[$id]);
            // Mise à jour de la session après suppression
            $session->set('posts', $posts);
        }

        // Redirection vers l'index des posts
        return $this->redirectToRoute('post_index');
    }
}
