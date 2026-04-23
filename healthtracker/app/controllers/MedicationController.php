<?php
require_once APP_PATH . '/models/MedicationModel.php';

class MedicationController extends Controller {
    private $model;

    public function __construct() {
        $this->model = new MedicationModel();
    }

    private function userId() {
        return $_SESSION['user']['id'] ?? 1;
    }

    public function index() {
        $this->requireLogin();
        $user  = $this->currentUser();
        $meds  = $this->model->getAll($this->userId());
        $flash = $_SESSION['flash'] ?? '';
        unset($_SESSION['flash']);
        $this->view('patient/medication', ['user' => $user, 'meds' => $meds, 'flash' => $flash]);
    }

    public function create() {
        $this->requireLogin();
        $user   = $this->currentUser();
        $errors = $_SESSION['form_errors'] ?? [];
        $old    = $_SESSION['form_old']    ?? [];
        unset($_SESSION['form_errors'], $_SESSION['form_old']);
        $this->view('patient/medication-form', [
            'user'   => $user,
            'med'    => null,
            'id'     => null,
            'errors' => $errors,
            'old'    => $old,
        ]);
    }

    public function store() {
        $this->requireLogin();
        $errors = $this->validateMed($_POST);
        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_old']    = $_POST;
            $this->redirect('medication-create');
        }
        $this->model->add($this->buildMed($_POST), $this->userId());
        $_SESSION['flash'] = 'Medication added successfully!';
        $this->redirect('medication');
    }

    public function edit() {
        $this->requireLogin();
        $user   = $this->currentUser();
        $id     = intval($_GET['id'] ?? 0);
        $med    = $this->model->findById($id, $this->userId());
        if (!$med) $this->redirect('medication');
        $errors = $_SESSION['form_errors'] ?? [];
        $old    = $_SESSION['form_old']    ?? $med;
        unset($_SESSION['form_errors'], $_SESSION['form_old']);
        $this->view('patient/medication-form', [
            'user'   => $user,
            'med'    => $med,
            'id'     => $id,
            'errors' => $errors,
            'old'    => $old,
        ]);
    }

    public function update() {
        $this->requireLogin();
        $id     = intval($_POST['id'] ?? 0);
        $errors = $this->validateMed($_POST);
        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_old']    = $_POST;
            $this->redirectWithQuery('medication-edit', ['id' => $id]);
        }
        $this->model->update($id, $this->buildMed($_POST), $this->userId());
        $_SESSION['flash'] = 'Medication updated successfully!';
        $this->redirect('medication');
    }

    public function delete() {
        $this->requireLogin();
        $id = intval($_GET['id'] ?? $_POST['id'] ?? 0);
        $this->model->delete($id, $this->userId());
        $_SESSION['flash'] = 'Medication removed.';
        $this->redirect('medication');
    }

    private function validateMed($data) {
        $errors = [];
        if (empty(trim($data['name']     ?? ''))) $errors[] = 'Medication name is required.';
        if (empty(trim($data['dosage']   ?? ''))) $errors[] = 'Dosage is required.';
        if (empty(trim($data['schedule'] ?? ''))) $errors[] = 'Schedule is required.';
        if (empty(trim($data['type']     ?? ''))) $errors[] = 'Type is required.';
        return $errors;
    }

    private function buildMed($data) {
        return [
            'name'       => trim($data['name']),
            'dosage'     => trim($data['dosage']),
            'schedule'   => trim($data['schedule']),
            'type'       => trim($data['type']),
            'start_date' => $data['start_date'] ?? date('Y-m-d'),
            'end_date'   => $data['end_date']   ?? '',
            'prescriber' => trim($data['prescriber'] ?? ''),
            'notes'      => trim($data['notes']      ?? ''),
            'status'     => $data['status'] ?? 'Active',
            'icon'       => $data['icon']   ?? '💊',
        ];
    }
}
