<?php
require_once APP_PATH . '/models/UserModel.php';
require_once APP_PATH . '/models/HealthRecordModel.php';
require_once APP_PATH . '/models/MedicationModel.php';
require_once APP_PATH . '/models/AppointmentModel.php';

class PatientController extends Controller {
    private $userModel;
    private $healthModel;
    private $medModel;
    private $apptModel;

    public function __construct() {
        $this->userModel   = new UserModel();
        $this->healthModel = new HealthRecordModel();
        $this->medModel    = new MedicationModel();
        $this->apptModel   = new AppointmentModel();
    }

    private function userId() {
        return $_SESSION['user']['id'] ?? 1;
    }

    public function dashboard() {
        $this->requireLogin();
        $user    = $this->currentUser();
        $uid     = $this->userId();
        $records = $this->healthModel->getAll($uid);
        $latest  = $records[0] ?? null;
        $meds    = $this->medModel->getAll($uid);
        $appointments = $this->apptModel->getAll($uid);
        $upcoming = array_values(array_filter($appointments, fn($a) => $a['status'] === 'Scheduled'));
        $this->view('patient/dashboard', [
            'user'         => $user,
            'latest'       => $latest,
            'records'      => array_slice($records, 0, 5),
            'meds'         => array_slice($meds, 0, 4),
            'appointments' => array_slice($upcoming, 0, 3),
        ]);
    }

    public function progress() {
        $this->requireLogin();
        $user    = $this->currentUser();
        $records = $this->healthModel->getAll($this->userId());
        $this->view('patient/progress', ['user' => $user, 'records' => $records]);
    }

    public function reminders() {
        $this->requireLogin();
        $this->view('patient/reminders', ['user' => $this->currentUser()]);
    }

    public function profile() {
        $this->requireLogin();
        $this->view('patient/profile', ['user' => $this->currentUser()]);
    }

    public function settings() {
        $this->requireLogin();
        $success = '';
        $error   = '';
        $user    = $this->currentUser();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['disable_2fa'])) {
                $this->userModel->update2FA($user['id'], null, 0);
                $_SESSION['user']['two_fa_enabled'] = 0;
                $success = 'Two-factor authentication disabled.';
                $user    = $this->currentUser();
            } else {
                $success = 'Preferences saved!';
            }
        }

        $this->view('patient/settings', [
            'user'    => $user,
            'success' => $success,
            'error'   => $error,
        ]);
    }

    public function bmi() {
        $this->requireLogin();
        $records = $this->healthModel->getAll($this->userId());
        $this->view('patient/bmi', [
            'user'    => $this->currentUser(),
            'records' => $records,
        ]);
    }
}