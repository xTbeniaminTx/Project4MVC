<?php

// require_once('model/ChapterManager.php');

class BaseController extends Controller
{
    public function __construct()
    {
        $this->chapterModel = $this->model('Chapter');
        $this->commentModel = $this->model('Comment');
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
        $photoId = rand(10, 50);

        $data = [
            'title' => "Admin Chapters",
            'chapters' => $chapters,
            'ben' => 'Beniamin Tolan',
            'photoId' => $photoId
        ];
        global $twig;
        $vue = $twig->load('chapters.html.twig');
        echo $vue->render($data);
    }

    public function showChapter()
    {
        $chapters = $this->chapterModel->getChaptersById($_GET['id']);
        $comments = $this->commentModel->getComments();
        $photoId = rand(10, 50);

        $data = [
            'chapters' => $chapters,
            'comments' => $comments,
            'id' => 10 + rand(10, 50),
            'photoId' => $photoId
        ];
        global $twig;
        $vue = $twig->load('chapter.html.twig');
        echo $vue->render($data);

    }

    public function addComment()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Sanitize the post
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $comments = $this->commentModel->getComments();
            $comment = $this->commentModel->getCommentById($_GET['id']);
            $id = $comment->comment_chapter_id;

            $data = [
                'comment_author' => trim($_POST['comment_author']),
                'comment_email' => trim($_POST['comment_email']),
                'comment_content' => trim($_POST['comment_content']),
                'comment_chapter_id' => $id,
                'comment_date' => time(),
                'comment_status' => 'approuved',
                'comment_author_err' => '',
                'comment_email_err' => '',
                'comment_content_err' => '',
            ];

            //Validate data
            if (empty($data['comment_author'])) {
                $data['comment_author_err'] = 'Veuillez entre un author';
            }
            if (empty($data['comment_email'])) {
                $data['comment_email_err'] = 'Veuillez entre un mail valid';
            }
            if (empty($data['comment_content'])) {
                $data['comment_content_err'] = 'Veuillez entre un contenu pour votre commentaire';
            }

            //make sure errors are empty
            if (empty($data['comment_author_err']) && empty($data['comment_email_err']) && empty($data['comment_content_err'])) {
                //validated
                if ($this->commentModel->addComment($data)) {
                    header('Location: index.php?action=showChapter&id='.$data['comment_chapter_id']);
                    flash('comment_message', 'Nouveau commentaire ajoute avec success');
                } else {
                    die('qq terible vien de se passer');
                }

            } else {
                //load view with errors
                global $twig;
                $vue = $twig->load('chapter.html.twig');
                echo $vue->render($data);
            }
        } else {
            $data = [
                'comment_author' => '',
                'comment_email' => '',
                'comment_content' => '',
            ];
            global $twig;
            $vue = $twig->load('chapter.html.twig');
            echo $vue->render($data);
        }
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