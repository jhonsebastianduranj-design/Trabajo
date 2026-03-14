<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Patient;

class PatientController extends Controller
{
    private Patient $patientModel;

    public function __construct()
    {
        $this->patientModel = new Patient();
    }

    private function ensureAuth(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }

    public function index(): void
    {
        $this->ensureAuth();
        $patients = $this->patientModel->all();
        $this->view('patients/index', ['title' => 'Pacientes', 'patients' => $patients]);
    }

    public function create(): void
    {
        $this->ensureAuth();
        $this->view('patients/create', ['title' => 'Registrar paciente']);
    }

    public function store(): void
    {
        $this->ensureAuth();
        $data = $this->validatedData();

        if ($data === null) {
            $this->redirect('/patients/create');
        }

        $this->patientModel->create($data);
        $_SESSION['success'] = 'Paciente registrado correctamente';
        $this->redirect('/patients');
    }

    public function edit(): void
    {
        $this->ensureAuth();
        $id = (int) ($_GET['id'] ?? 0);
        $patient = $this->patientModel->find($id);

        if (!$patient) {
            $_SESSION['error'] = 'Paciente no encontrado';
            $this->redirect('/patients');
        }

        $this->view('patients/edit', ['title' => 'Editar paciente', 'patient' => $patient]);
    }

    public function update(): void
    {
        $this->ensureAuth();
        $id = (int) ($_POST['id'] ?? 0);
        $data = $this->validatedData();

        if ($id <= 0 || $data === null) {
            $this->redirect('/patients');
        }

        $this->patientModel->update($id, $data);
        $_SESSION['success'] = 'Paciente actualizado correctamente';
        $this->redirect('/patients');
    }

    public function delete(): void
    {
        $this->ensureAuth();
        $id = (int) ($_GET['id'] ?? 0);

        if ($id > 0) {
            $this->patientModel->delete($id);
            $_SESSION['success'] = 'Paciente eliminado correctamente';
        }

        $this->redirect('/patients');
    }

    private function validatedData(): ?array
    {
        $required = ['full_name', 'document_type', 'address', 'mobile', 'birth_date', 'age', 'eps', 'exam_type', 'company', 'exam_date'];

        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $_SESSION['error'] = 'Todos los campos obligatorios deben diligenciarse';
                return null;
            }
        }

        return [
            'full_name' => trim($_POST['full_name']),
            'document_type' => trim($_POST['document_type']),
            'address' => trim($_POST['address']),
            'phone' => trim($_POST['phone'] ?? ''),
            'mobile' => trim($_POST['mobile']),
            'birth_date' => trim($_POST['birth_date']),
            'age' => (int) $_POST['age'],
            'eps' => trim($_POST['eps']),
            'additional_contact' => trim($_POST['additional_contact'] ?? ''),
            'kinship' => trim($_POST['kinship'] ?? ''),
            'exam_type' => trim($_POST['exam_type']),
            'company' => trim($_POST['company']),
            'exam_date' => trim($_POST['exam_date']),
        ];
    }
}
