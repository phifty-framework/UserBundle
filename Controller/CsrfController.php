<?php
namespace UserBundle\Controller;
use Phifty\Controller;

/**
 * Csrf Token service provider with Simple CORS
 *
 * @see https://developer.mozilla.org/zh-TW/docs/HTTP/Access_control_CORS
 *
 * @see https://developer.mozilla.org/en-US/Persona/The_implementor_s_guide/Problems_integrating_with_CRSF_protection
 */
class CsrfController extends Controller
{
    public function indexAction()
    {
        $kernel = kernel();
        header('Access-Control-Allow-Origin: ' . $kernel->getBaseUrl());
        header('Access-Control-Allow-Methods: GET');

        $domain = $kernel->config->get('framework','Domain');
        if ($_SERVER['HTTP_HOST'] != $domain) {
            return $this->toJson([
                'error' => 'access denied'
            ]);
        }

        $currentUser = $kernel->currentUser;
        if (!$currentUser->isLogged()) {
            return $this->toJson([
                'error' => 'login required',
                'redirect' => '/bs/login',
            ]);
        }

        $token = $kernel->actionService['csrf_token'];
        return $this->toJson($token->toPublicArray());
    }
}
