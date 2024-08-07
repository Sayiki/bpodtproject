<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\WisataModel;
use App\Models\VisitorModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('login');
    }

    public function validateLogin()
    {
        $session = session();
        $adminModel = new AdminModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');



        $admin = $adminModel->where('username', $username)->first();

        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('dashboard'));
        }

        if ($admin) {
            if (password_verify($password, $admin['password'])) {
                $ses_data = [
                    'id' => $admin['id'],
                    'username' => $admin['username'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/dashboard');

            } else {
                // Debug information
                log_message('error', 'Login failed for user: ' . $username);
                log_message('error', 'Provided password: ' . $password);
                log_message('error', 'Stored password hash: ' . $admin['password']);

                $session->setFlashdata('msg', 'Password is incorrect.');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Username does not exist.');
            return redirect()->to('/login');
        }
    }

    public function dashboard()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        $wisataModel = new WisataModel();
        $visitorModel = new VisitorModel();

        $today = date('Y-m-d');
        $monthAgo = date('Y-m-d', strtotime('-1 month'));

        $data = [
            'totalWisata' => $wisataModel->getTotalWisata(),
            'totalVisits' => $visitorModel->getTotalVisits(),
            'visitsLastMonth' => $visitorModel->getVisitsForDateRange($monthAgo, $today),
            'mostVisitedWisata' => $wisataModel->getMostVisitedWisata()
        ];
        
        return view('dashboard', $data);
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('/'))->with('message', 'You have been logged out successfully');
    }

    private function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function updateAdminPassword()
    {
        $adminModel = new AdminModel();
        $admin = $adminModel->find(1); // Assuming the admin id is 1

        if ($admin) {
            $newPassword = 'admin999';
            $hashedPassword = $this->hashPassword($newPassword);
            $adminModel->update($admin['id'], ['password' => $hashedPassword]);
            echo "Password updated successfully";
        } else {
            echo "Admin not found";
        }
    }

    public function checkPasswordHash()
    {
        $adminModel = new AdminModel();
        $admin = $adminModel->find(1); // Assuming the admin id is 1

        if ($admin) {
            echo "Current password hash: " . $admin['password'];
        } else {
            echo "Admin not found";
        }
    }

    public function testPasswordHash()
    {
        $password = 'admin999*';
        $hash = password_hash($password, PASSWORD_DEFAULT);
        echo "Password: $password<br>";
        echo "Hash: $hash<br>";
        echo "Verify: " . (password_verify($password, $hash) ? 'true' : 'false');
    }
}