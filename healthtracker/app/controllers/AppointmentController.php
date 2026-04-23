<?php
require_once APP_PATH . '/models/AppointmentModel.php';

class AppointmentController extends Controller {
    private $model;

    public function __construct() {
        $this->model = new AppointmentModel();
    }

    private function userId() {
        return $_SESSION['user']['id'] ?? 1;
    }

    public function index() {
        $this->requireLogin();
        $user         = $this->currentUser();
        $appointments = $this->model->getAll($this->userId());
        $flash        = $_SESSION['flash'] ?? '';
        unset($_SESSION['flash']);
        $this->view('patient/appointments', [
            'user'         => $user,
            'appointments' => $appointments,
            'flash'        => $flash,
        ]);
    }

    public function create() {
        $this->requireLogin();
        $user   = $this->currentUser();
        $errors = $_SESSION['form_errors'] ?? [];
        $old    = $_SESSION['form_old']    ?? [];
        unset($_SESSION['form_errors'], $_SESSION['form_old']);
        $this->view('patient/appointment-form', [
            'user'        => $user,
            'appointment' => null,
            'id'          => null,
            'errors'      => $errors,
            'old'         => $old,
        ]);
    }

    public function store() {
        $this->requireLogin();
        $errors = $this->validateAppt($_POST);
        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_old']    = $_POST;
            $this->redirect('appointments-create');
        }
        $this->model->add($this->buildAppt($_POST), $this->userId());
        $_SESSION['flash'] = 'Appointment scheduled successfully!';
        $this->redirect('appointments');
    }

    public function edit() {
        $this->requireLogin();
        $user        = $this->currentUser();
        $id          = intval($_GET['id'] ?? 0);
        $appointment = $this->model->findById($id, $this->userId());
        if (!$appointment) $this->redirect('appointments');
        $errors = $_SESSION['form_errors'] ?? [];
        $old    = $_SESSION['form_old']    ?? $appointment;
        unset($_SESSION['form_errors'], $_SESSION['form_old']);
        $this->view('patient/appointment-form', [
            'user'        => $user,
            'appointment' => $appointment,
            'id'          => $id,
            'errors'      => $errors,
            'old'         => $old,
        ]);
    }

    public function update() {
        $this->requireLogin();
        $id     = intval($_POST['id'] ?? 0);
        $errors = $this->validateAppt($_POST);
        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_old']    = $_POST;
            $this->redirectWithQuery('appointments-edit', ['id' => $id]);
        }
        $this->model->update($id, $this->buildAppt($_POST), $this->userId());
        $_SESSION['flash'] = 'Appointment updated successfully!';
        $this->redirect('appointments');
    }

    public function delete() {
        $this->requireLogin();
        $id = intval($_GET['id'] ?? $_POST['id'] ?? 0);
        $this->model->delete($id, $this->userId());
        $_SESSION['flash'] = 'Appointment cancelled.';
        $this->redirect('appointments');
    }

    private function validateAppt($data) {
        $errors = [];
        if (empty(trim($data['doctor']    ?? ''))) $errors[] = 'Doctor name is required.';
        if (empty(trim($data['specialty'] ?? ''))) $errors[] = 'Specialty is required.';
        if (empty($data['date']           ?? ''))  $errors[] = 'Date is required.';
        if (empty($data['time']           ?? ''))  $errors[] = 'Time is required.';
        return $errors;
    }

    private function buildAppt($data) {
        return [
            'doctor'    => trim($data['doctor']),
            'specialty' => trim($data['specialty']),
            'date'      => $data['date'],
            'time'      => $data['time'],
            'location'  => trim($data['location'] ?? ''),
            'type'      => $data['type']   ?? 'Check-up',
            'status'    => $data['status'] ?? 'Scheduled',
            'notes'     => trim($data['notes'] ?? ''),
        ];
    }
}
