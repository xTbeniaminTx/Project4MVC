<?php

// require_once('model/CommentManager.php');

class AdminController extends Controller
{
    public function __construct()
    {
        $this->loginModel = $this->model('Login');
        $this->chapterModel = $this->model('Chapter');
    }

    public function adminView()
    {
        if ($this->isLoggedIn()) {
            global $twig;
            $vue = $twig->load('admin.base.html.twig');
            echo $vue->render([
                'title' => "Admin Dashboard",
                'admin_id' => $_SESSION['admin_id']
            ]);
        } else {
            header('Location: index.php?action=adminLogin');
        }

    }

    public function adminChapters()
    {
        if ($this->isLoggedIn()) {
            $chapters = $this->chapterModel->getChapters();
            $chapter_message = flash('chapter_message');
            $message_chapter = <<<EOD
                    $chapter_message
EOD;
            $chapter = null;
            if (isset($_GET['id'])) {
                $chapter = $this->chapterModel->getChaptersById($_GET['id']);
            }


            $data = [
                'title' => "Admin Chapters",
                'chapters' => $chapters,
                'ben' => 'Beniamin Tolan',
                'chapter_message' => $message_chapter,
                'chapter' => $chapter
            ];
            global $twig;
            $vue = $twig->load('admin.chapters.html.twig');
            echo $vue->render($data);
        } else {
            header('Location: index.php?action=adminLogin');
        }

    }

    public function addChapter()
    {
        if ($this->isLoggedIn()) {


            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                //Sanitize the post
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'title' => trim($_POST['title']),
                    'content' => trim($_POST['content']),
                    'admin_id' => $_SESSION['admin_id'],
                    'title_err' => '',
                    'content_err' => '',
                ];

                //Validate data
                if (empty($data['title'])) {
                    $data['title_err'] = 'Veuillez entre un titre';
                }
                if (empty($data['content'])) {
                    $data['content_err'] = 'Veuillez entre un contenu pour votre chapitre';
                }

                //make sure errors are empty
                if (empty($data['title_err']) && empty($data['content_err'])) {
                    //validated
                    if ($this->chapterModel->addChapter($data)) {
                        header('Location: index.php?action=adminChapters');
                        flash('chapter_message', 'Nouveau chapitre ajoute avec success');
                    } else {
                        die('qq terible vien de se passer');
                    }

                } else {
                    //load view with errors
                    global $twig;
                    $vue = $twig->load('admin.edit.chapters.html.twig');
                    echo $vue->render($data);
                }
            } else {
                $data = [
                    'title' => '',
                    'content' => '',
                ];
                global $twig;
                $vue = $twig->load('admin.edit.chapters.html.twig');
                echo $vue->render($data);
            }


        } else {
            header('Location: index.php?action=adminLogin');
        }
    }

    public function editChapter()
    {
        if ($this->isLoggedIn()) {


            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                //Sanitize the post
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if (isset($_GET['id'])) {
                    $chapter = $this->chapterModel->getChaptersById($_GET['id']);
                }
                $data = [
                    'title' => trim($_POST['title']),
                    'content' => trim($_POST['content']),
                    'admin_id' => $_SESSION['admin_id'],
                    'id' => $chapter->id,
                    'title_err' => '',
                    'content_err' => '',
                ];

                //Validate data
                if (empty($data['title'])) {
                    $data['title_err'] = 'Veuillez entre un titre';
                }
                if (empty($data['content'])) {
                    $data['content_err'] = 'Veuillez entre un contenu pour votre chapitre';
                }

                //make sure errors are empty
                if (empty($data['title_err']) && empty($data['content_err'])) {
                    //validated
                    if ($this->chapterModel->updateChapter($data)) {
                        header('Location: index.php?action=adminChapters');
                        flash('chapter_message', 'Le chapitre a ete modifiee avec success');
                    } else {
                        die('qq terible vien de se passer');
                    }

                } else {
                    //load view with errors
                    global $twig;
                    $vue = $twig->load('admin.edit.chapters.html.twig');
                    echo $vue->render($data);
                }
            } else {
                $chapter = $this->chapterModel->getChaptersById($_GET['id']);
                $data = [
                    'title' => $chapter->title,
                    'content' => $chapter->content,
                    'id' => $chapter->id,
                    'chapter' => $chapter
                ];
                global $twig;
                $vue = $twig->load('admin.edit.chapters.html.twig');
                echo $vue->render($data);
            }

        } else {
            header('Location: index.php?action=adminLogin');
        }

    }


    public function adminComments()
    {
        if ($this->isLoggedIn()) {
            global $twig;
            $vue = $twig->load('admin.comments.html.twig');
            echo $vue->render([
                'title' => "Admin Comments",
                'ben' => 'Beniamin Tolan'
            ]);
        } else {
            header('Location: index.php?action=adminLogin');
        }
    }


    public function adminLogin()
    {
        if ($this->isLoggedIn()) {
            header('Location: index.php?action=adminView');
        } else {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                //process form
                //Sanitaze POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                //init data
                $data = [
                    'email' => trim($_POST['email']),
                    'email_err' => '',
                    'password' => trim($_POST['password']),
                    'password_err' => ''
                ];


                //check if email is entered
                if (empty($data['email'])) {
                    $data['email_err'] = 'Veuillez entre votre email';
                }

                //check if password is entered
                if (empty($data['password'])) {
                    $data['password_err'] = 'Veuillez entre votre mot de passe';
                }

                //check for email
                if ($this->loginModel->findByEmail($data['email'])) {
                    //email found
                } else {
                    $data['email_err'] = 'No user found';
                }

                //make sure errors are empty
                if (empty($data['email_err']) && empty($data['password_err'])) {
                    //validated
                    //check and set logged user


                    $loggedInAdmin = $this->loginModel->login($data['email'], $data['password']);

                    if ($loggedInAdmin) {
                        //create session
                        $this->createSession($loggedInAdmin);
                    } else {
                        $data['password_err'] = 'Mot de passe inccorect';
                        //load view with errors
                        global $twig;
                        $vue = $twig->load('admin.login.html.twig');
                        echo $vue->render($data);
                    }
                } else {
                    //load view with errors
                    global $twig;
                    $vue = $twig->load('admin.login.html.twig');
                    echo $vue->render($data);
                }

            } else {
                //init data
                $data = [
                    'email' => '',
                    'email_err' => '',
                    'password' => '',
                    'password_err' => ''
                ];

                //load view
                global $twig;
                $vue = $twig->load('admin.login.html.twig');
                echo $vue->render($data);
            }
        }

    }

    public function createSession($login)
    {
        $_SESSION['admin_id'] = $login->id;
        $_SESSION['admin_email'] = $login->email;
        header('Location: index.php?action=adminChapters');
    }

    public function logout()
    {
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_email']);
        session_destroy();
        header('Location: index.php?action=home');
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