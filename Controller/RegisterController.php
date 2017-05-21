<?php
namespace UserBundle\Controller;
use Phifty\Controller;

class RegisterController extends Controller
{
    public function indexAction() {
        return $this->render("@UserBundle/register.html");
    }
}
