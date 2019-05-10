<?php

// require_once('model/ChapterManager.php');

class BaseController
{
    public function home()
    {
        // $chapterManager = new Blog\Model\ChapterManager();

        global $twig;
        $vue = $twig->load('home.html.twig');
        echo $vue->render([
            'titre' => "salut",
            'ben' => 'Beniamin Tolan'
        ]);

    }

    public function contact()
    {
        global $twig;
        $vue = $twig->load('contact.html.twig');
        echo $vue->render([
            'titre' => "salut",
            'ben' => 'Beniamin Tolan'
        ]);

    }


    public function books()
    {
        global $twig;
        $vue = $twig->load('books.html.twig');
        echo $vue->render([
            'titre' => "salut",
            'ben' => 'Beniamin Tolan'
        ]);

    }
}