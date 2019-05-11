<?php

// require_once('model/CommentManager.php');

class AdminController
{
	public function adminView()
	{
        global $twig;
        $vue = $twig->load('admin.html.twig');
        echo $vue->render([
            'titre' => "salut",
            'ben' => 'Beniamin Tolan'
        ]);
	}

    public function adminComments()
    {
        global $twig;
        $vue = $twig->load('adminComments.html.twig');
        echo $vue->render([
            'titre' => "salut",
            'ben' => 'Beniamin Tolan'
        ]);
    }
}