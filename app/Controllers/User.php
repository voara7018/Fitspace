<?php

namespace App\Controllers;
use App\Models\UserModel;

class User extends BaseController
{
    public function showLogin()
    {
        $data = [];
        if (session()->getFlashdata('validation')) {
            $data['validation'] = session()->getFlashdata('validation');
        }
        return view('login', $data);
    }

    public function showInscription()
    {
        $data = [];
        if (session()->getFlashdata('validation')) {
            $data['validation'] = session()->getFlashdata('validation');
        }
        return view('signin', $data);
    }
    
    public function insertUser()
    {
        $model = new UserModel();
        $data = $this->request->getPost();
        
        // Force key roles
        $data['role'] = 'client';

        if (!$model->insert($data)) {
            return redirect()->to('/inscription')->withInput()->with('validation', $model->errors());
        } 
        
        return redirect()->to('/')->with('success', 'Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter.');
    }

    public function loginUser()
    {
        $model = new UserModel();
        
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email'    => 'required|valid_email',
            'password' => 'required'
        ], [
            'email' => [
                'required' => 'L\'adresse email est requise.',
                'valid_email' => 'L\'adresse email doit être valide.'
            ],
            'password' => [
                'required' => 'Le mot de passe est requis.'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->to('/')->withInput()->with('validation', $validation->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)->first();    

        if ($user && password_verify($password, $user['password'])) {
            $session = session();
            $session->set([
                'id'         => $user['id'],
                'nom'        => $user['nom'],
                'role'       => $user['role'],
                'isLoggedIn' => true
            ]);

            if ($user['role'] === 'admin') {
                return redirect()->to('/admin');
            } else {
                return redirect()->to('/creneaux');
            }
        } else {
            return redirect()->to('/')->withInput()->with('error', 'Email ou mot de passe incorrect.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
