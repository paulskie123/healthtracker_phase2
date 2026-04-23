<?php
require_once APP_PATH . '/models/HealthRecordModel.php';

class HealthRecordController extends Controller {
    private $model;

    public function __construct() {
        $this->model = new HealthRecordModel();
    }

    private function userId() {
        return $_SESSION['user']['id'] ?? 1;
    }

    public function index() {
        $this->requireLogin();
        $user    = $this->currentUser();
        $records = $this->model->getAll($this->userId());
        $flash   = $_SESSION['flash'] ?? '';
        unset($_SESSION['flash']);
        $this->view('patient/health-records', [
            'user'    => $user,
            'records' => $records,
            'flash'   => $flash,
        ]);
    }

    public function show() {
        $this->requireLogin();
        $user   = $this->currentUser();
        $id     = intval($_GET['id'] ?? 0);
        $record = $this->model->findById($id, $this->userId());
        if (!$record) $this->redirect('health-records');
        $this->view('patient/health-record-view', [
            'user'   => $user,
            'record' => $record,
            'id'     => $id,
        ]);
    }

    public function create() {
        $this->requireLogin();
        $user   = $this->currentUser();
        $errors = $_SESSION['form_errors'] ?? [];
        $old    = $_SESSION['form_old']    ?? [];
        unset($_SESSION['form_errors'], $_SESSION['form_old']);
        $this->view('patient/health-record-form', [
            'user'   => $user,
            'record' => null,
            'id'     => null,
            'errors' => $errors,
            'old'    => $old,
        ]);
    }

    public function store() {
        $this->requireLogin();
        $errors = $this->validateRecord($_POST);
        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_old']    = $_POST;
            $this->redirect('health-records-create');
        }
        $this->model->add($this->buildRecord($_POST), $this->userId());
        $_SESSION['flash'] = 'Health record added successfully!';
        $this->redirect('health-records');
    }

    public function edit() {
        $this->requireLogin();
        $user   = $this->currentUser();
        $id     = intval($_GET['id'] ?? 0);
        $record = $this->model->findById($id, $this->userId());
        if (!$record) $this->redirect('health-records');
        $errors = $_SESSION['form_errors'] ?? [];
        $old    = $_SESSION['form_old']    ?? $record;
        unset($_SESSION['form_errors'], $_SESSION['form_old']);
        $this->view('patient/health-record-form', [
            'user'   => $user,
            'record' => $record,
            'id'     => $id,
            'errors' => $errors,
            'old'    => $old,
        ]);
    }

    public function update() {
        $this->requireLogin();
        $id     = intval($_POST['id'] ?? 0);
        $errors = $this->validateRecord($_POST);
        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_old']    = $_POST;
            $this->redirectWithQuery('health-records-edit', ['id' => $id]);
        }
        $this->model->update($id, $this->buildRecord($_POST), $this->userId());
        $_SESSION['flash'] = 'Health record updated successfully!';
        $this->redirect('health-records');
    }

    public function delete() {
        $this->requireLogin();
        $id = intval($_GET['id'] ?? $_POST['id'] ?? 0);
        $this->model->delete($id, $this->userId());
        $_SESSION['flash'] = 'Health record deleted.';
        $this->redirect('health-records');
    }

    private function validateRecord($data) {
        $errors = [];
        if (empty($data['date']))                                         $errors[] = 'Date is required.';
        if (!isset($data['systolic_bp'])  || $data['systolic_bp']  < 60) $errors[] = 'Systolic BP must be ≥ 60.';
        if (!isset($data['diastolic_bp']) || $data['diastolic_bp'] < 40) $errors[] = 'Diastolic BP must be ≥ 40.';
        if (!isset($data['heart_rate'])   || $data['heart_rate']   < 30) $errors[] = 'Heart rate must be ≥ 30.';
        if (!isset($data['weight'])       || $data['weight']       <= 0) $errors[] = 'Weight must be > 0.';
        if (!isset($data['blood_sugar'])  || $data['blood_sugar']  < 40) $errors[] = 'Blood sugar must be ≥ 40.';
        return $errors;
    }

    private function buildRecord($data) {
        return [
            'date'         => $data['date'],
            'systolic_bp'  => intval($data['systolic_bp']),
            'diastolic_bp' => intval($data['diastolic_bp']),
            'heart_rate'   => intval($data['heart_rate']),
            'weight'       => floatval($data['weight']),
            'blood_sugar'  => floatval($data['blood_sugar']),
            'notes'        => trim($data['notes'] ?? ''),
        ];
    }
}