<?php

$loader = new Twig_Loader_Filesystem(ROOT . DS . 'src' . DS . 'views');
$twig = new Twig_Environment($loader);
