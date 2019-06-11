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
        if ($this->isLoggedIn()) {
            header('Location: index.php?action=adminView');
        }

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

    public function showChapter($id)
    {
        $chapters = $this->chapterModel->getChaptersById($id);

        $data = [
          'chapters' => $chapters
        ];
        global $twig;
        $vue = $twig->load('chapter.html.twig');
        echo $vue->render($data);

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

    public function isLoggedIn()
    {
        if (isset($_SESSION['admin_id'])) {
            return true;
        } else {
            return false;
        }
    }
}