<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\PostManager;
use Cocur\Slugify\Slugify;

/**
 * Class ItemController
 *
 */
class PostController extends AbstractController
{


    /**
     * Display item listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        // ---- Modèle ----
        $postManager = new PostManager();
        $posts = $postManager->selectAll();

        // ---- Parfois le contrôleur a un peu plus de travail !!!

        // ---- Vue ----
        return $this->twig->render('Post/index.html.twig', ['posts' => $posts]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postManager = new PostManager();

            $trimmedTitle = trim($_POST['title']);

            if ($trimmedTitle === '') {
              return $this->twig->render('Post/add.html.twig', [
                'error' => 'Title must not be empty'
              ]);
            }

            $slugify = new Slugify();
            $slug = $slugify->slugify($trimmedTitle);

            $post = [
                'title' => $trimmedTitle,
                'slug' => $slug,
                'content' => $_POST['content'],
            ];

            $id = $postManager->insert($post);
            header('Location:/post/show/' . $id);
        }

        return $this->twig->render('Post/add.html.twig');
    }

    public function show(string $slug)
    {
        $postManager = new PostManager();
        $post = $postManager->selectOneBySlug($slug);

        return $this->twig->render('Post/show.html.twig', [
            'post' => $post
        ]);
    }
}