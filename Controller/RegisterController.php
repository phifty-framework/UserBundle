<?php
namespace UserBundle\Controller;
use Phifty\Routing\Controller;

class RegisterController extends Controller
{
    public function indexAction() {
        return $this->render("@UserBundle/register.html.twig");
    }
}
