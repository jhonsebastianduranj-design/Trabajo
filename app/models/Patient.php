<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Patient
{
    private PDO $db;

    public function __construct()
    {
        $config = require __DIR__ . '/../config/config.php';
        $this->db = Database::getInstance($config);
    }

    public function all(): array
    {
        $stmt = $this->db->query('SELECT * FROM patients ORDER BY exam_date DESC');
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM patients WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $patient = $stmt->fetch();

        return $patient ?: null;
    }

    public function create(array $data): bool
    {
        $sql = 'INSERT INTO patients
        (full_name, document_type, address, phone, mobile, birth_date, age, eps, additional_contact, kinship, exam_type, company, exam_date)
        VALUES
        (:full_name, :document_type, :address, :phone, :mobile, :birth_date, :age, :eps, :additional_contact, :kinship, :exam_type, :company, :exam_date)';

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
    }

    public function update(int $id, array $data): bool
    {
        $sql = 'UPDATE patients SET
        full_name=:full_name,
        document_type=:document_type,
        address=:address,
        phone=:phone,
        mobile=:mobile,
        birth_date=:birth_date,
        age=:age,
        eps=:eps,
        additional_contact=:additional_contact,
        kinship=:kinship,
        exam_type=:exam_type,
        company=:company,
        exam_date=:exam_date
        WHERE id=:id';

        $data['id'] = $id;
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM patients WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
