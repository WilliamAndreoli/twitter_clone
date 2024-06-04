<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action
{

    public function timeline()
    {

        session_start();

        $this->validaAutenticacao();

        //recuperação dos tweets
        $tweet = Container::getModel('tweet');

        $tweet->__set('id_usuario', $_SESSION['id']);

        $tweets = $tweet->getAll();

        $this->view->tweets = $tweets;

        $this->render('timeline');


    }

    public function tweet()
    {

        session_start();

        $this->validaAutenticacao();

        $tweet = Container::getModel('Tweet');

        if ($_POST['tweet'] != '') {

            $tweet->__set('tweet', $_POST['tweet']);
            $tweet->__set('id_usuario', $_SESSION['id']);

            $tweet->salvar();

            header('Location: /timeline');

        } else {

            header('Location: /timeline?tweet=erro');

        }


    }

    public function validaAutenticacao()
    {

        session_start();

        if (!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == '') {
            header('Location /?login=erro');
        }

    }

    public function quemSeguir() {

        $this->validaAutenticacao();

        echo '<br><br><br><br><br><br>';
        $pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';

        echo 'Pesquisando por: '.$pesquisarPor;

        $usuarios = array();
        
        if ($pesquisarPor != '') {
            
            $usuario = Container::getModel('Usuario');

            $usuario->__set('nome', $pesquisarPor);
            $usuarios = $usuario->getAll();

            echo '<pre>';
            print_r($usuarios);
            echo '</pre>';
        }

        $this->view->usuarios = $usuarios;

        $this->render('quemSeguir');

    }

}

?>