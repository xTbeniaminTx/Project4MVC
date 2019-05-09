<?php

// require_once('model/ChapterManager.php');

class BaseController
{
	public function home()
	{
		// $chapterManager = new Blog\Model\ChapterManager();

//		require('view/frontend/home.php');
        $loader = new \Twig\Loader\FilesystemLoader(APPROOT.'/views/pages');
        $twig = new \Twig\Environment($loader, [
            'auto_load' => true,
            'debug' => true
        ]);
        $vue = $twig->load('home.html.twig');
        echo $vue->render([
            'titre' => "salut",
            'ben' => 'Beniamin Tolan'
        ]);

	}
    public function contact() {
        $loader = new \Twig\Loader\FilesystemLoader(APPROOT.'/views/pages');
        $twig = new \Twig\Environment($loader, [
            'auto_load' => true,
            'debug' => true
        ]);
        $vue = $twig->load('contact.html.twig');
        echo $vue->render([
            'titre' => "salut",
            'ben' => 'Beniamin Tolan'
        ]);
    }
}