<?php

namespace App\Controller;

use Cake\Utility\Security;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Mailer\Email;

class LoginController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['login', 'register', 'recover', 'confirmEmail', 'recover', 'newPassword']);
    }

    public function login()
    {
        if ($this->Auth->User()) {
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);

                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Email ou senha inválido'));

            return $this->redirect($this->Auth->redirectUrl());
        }
    }

    public function register()
    {
        $userTable = TableRegistry::getTableLocator()->get('users');
        $user = $userTable->newEntity();
        if($this->request->is('POST')){
            $user = $userTable->patchEntity($user, $this->request->getData());
            if($userTable->save($user)){
                $token = Security::hash($user->email, 'sha256', false);

                // Alterar email de envio (setFrom) e link do site (SEU-SITE.COM)
                $link = "http://SEU-SITE.COM/login/confirm-email/" . $user->email . '/' . $token;
                $msg = "Para confirmar seu email, <a href=" . $link . ">clique aqui</a>.";
                $email = new Email('default');
                $email->setFrom(['SEU EMAIL AQUI' => 'Contato'])
                    ->setTo($user->email)
                    ->setSubject('Confirmação de email')
                    ->setEmailFormat('html');   //Remover ; aqui e descomentar linha abaixo
                    // ->send($msg);

                $this->Flash->success('Cadastrado com sucesso.');

                return $this->redirect(['action' => 'login']);
            } else {
                $this->Flash->error('Erro ao cadastrar usuário.');
            }
        }
        $this->set(compact('user'));
    }

    public function confirmEmail($email = null, $token = null)
    {
        $usersTable = TableRegistry::getTableLocator()->get('users');

        if ($token != null && $email != null && $token == Security::hash($email, 'sha256', false)) {
            $user = $usersTable->getUser($email);
            $user->confirm = '1';
            if ($usersTable->save($user)) {
                $this->Flash->success(__('Email confirmado com sucesso.'));
                return $this->redirect(['action' => 'login']);
            } else {
                $this->Flash->error(__('Não foi possível confirmar o email.'));
                return $this->redirect(['action' => 'login']);
            }
        } else {
            $this->Flash->error(__('Não foi possível confirmar o email.'));
            return $this->redirect(['action' => 'login']);
        }
    }

    public function recover()
    {
        $userTable = TableRegistry::getTableLocator()->get('users');
        $user = $userTable->newEntity();
        if($this->request->is('POST')){
            $user = $userTable->getUser($this->request->getData('email'));
            if($user){
                $token = Security::hash($user->id . $user->email, 'sha256', false);

                $link = "http://SEU-SITE.COM/login/new-password/" . $user->email . '/' . $token;
                $msg = "<p>Para recuperar sua senha, <a href=" . $link . ">clique aqui</a>.</p>";
                $email = new Email('default');
                $email->setFrom(['SEU-EMAIL.com' => 'Contato'])
                    ->setTo($user->email)
                    ->setSubject('Recuperar senha')
                    ->setEmailFormat('html')
                    ->send($msg);

                $this->Flash->success(__('Link de recuperação enviado, verifique seu email.'));
                return $this->redirect(['action' => 'login']);
            } else {
                $this->Flash->error('Erro com o link de recuperação.');
            }
        }
        $this->set(compact('user'));
    }

    public function newPassword($email = null, $token = null)
    {
        $userTable = TableRegistry::getTableLocator()->get('users');
        $user = $userTable->getUser($email);
        if ($email != null && $token != null && $token == Security::hash($user->id . $email, 'sha256', false)) {
            if ($this->request->is(['patch', 'post', 'put'])) {
                $user = $userTable->patchEntity($user, $this->request->getData());
                if ($userTable->save($user)) {
                    $this->Flash->success(__('Senha alterada com sucesso.'));
                    return $this->redirect(['action' => 'login']);
                } else {
                    $this->Flash->error(__('Erro ao salvar nova senha.'));
                }
            }
            $this->set(compact('user'));
        } else {
            $this->Flash->error(__('Link de recuperação incorreto. Por favor, tente novamente.'));
            return $this->redirect(['action' => 'recover']);
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
}
