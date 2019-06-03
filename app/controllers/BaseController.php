<?php

// require_once('model/ChapterManager.php');

class BaseController extends Controller
{
    public function __construct()
    {
        $this->chapterModel = $this->model('Chapter');
    }


    public function home()
    {
        // $chapterManager = new Blog\Model\ChapterManager();

        global $twig;
        $vue = $twig->load('home.html.twig');
        echo $vue->render([
            'title' => SITENAME,
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


    public function chapters()
    {
        $chapters = $this->chapterModel->getChapters();

        $data = [
            'title' => "Admin Chapters",
            'chapters' => $chapters,
            'ben' => 'Beniamin Tolan'
        ];
        global $twig;
        $vue = $twig->load('chapters.html.twig');
        echo $vue->render($data);
    }

    public function chapter()
    {
        global $twig;
        $vue = $twig->load('chapter.html.twig');
        echo $vue->render([
            'titre' => "salut",
            'ben' => 'Beniamin Tolan'
        ]);

    }

    public function bio()
    {
        global $twig;
        $vue = $twig->load('bio.html.twig');
        echo $vue->render([
            'titre' => "salut",
            'ben' => 'Beniamin Tolan'
        ]);

    }
}