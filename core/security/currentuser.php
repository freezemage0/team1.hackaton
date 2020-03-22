<?php
namespace Core\Security;

class CurrentUser
{
    protected $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function isAuthorized()
    {
        return $this->session->get('USER_ID') > 0;
    }

    public function authorize($id)
    {
        $this->session->set('USER_ID', $id);
    }

    public function logout()
    {
        $this->session->destroy();
    }
}