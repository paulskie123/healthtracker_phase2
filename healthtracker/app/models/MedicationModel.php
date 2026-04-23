<?php
require_once APP_PATH . '/models/Model.php';

class MedicationModel extends Model {

    public function getAll($userId = 1) {
        $stmt = $this->db->prepare(
            'SELECT * FROM medications WHERE user_id = ? ORDER BY name ASC'
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function findById($id, $userId = 1) {
        $stmt = $this->db->prepare(
            'SELECT * FROM medications WHERE id = ? AND user_id = ? LIMIT 1'
        );
        $stmt->execute([$id, $userId]);
        return $stmt->fetch() ?: null;
    }

    public function add($data, $userId = 1) {
        $stmt = $this->db->prepare(
            'INSERT INTO medications
             (user_id, name, type, dosage, schedule, start_date, end_date, prescriber, notes, status, icon)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $userId,
            $data['name'],
            $data['type']       ?? 'Tablet',
            $data['dosage'],
            $data['schedule'],
            $data['start_date'] ?: null,
            $data['end_date']   ?: null,
            $data['prescriber'] ?? '',
            $data['notes']      ?? '',
            $data['status']     ?? 'Active',
            $data['icon']       ?? '💊',
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update($id, $data, $userId = 1) {
        $stmt = $this->db->prepare(
            'UPDATE medications
             SET name=?, type=?, dosage=?, schedule=?, start_date=?, end_date=?,
                 prescriber=?, notes=?, status=?, icon=?
             WHERE id=? AND user_id=?'
        );
        $stmt->execute([
            $data['name'],
            $data['type']       ?? 'Tablet',
            $data['dosage'],
            $data['schedule'],
            $data['start_date'] ?: null,
            $data['end_date']   ?: null,
            $data['prescriber'] ?? '',
            $data['notes']      ?? '',
            $data['status']     ?? 'Active',
            $data['icon']       ?? '💊',
            $id,
            $userId,
        ]);
        return true;
    }

    public function delete($id, $userId = 1) {
        $stmt = $this->db->prepare(
            'DELETE FROM medications WHERE id = ? AND user_id = ?'
        );
        $stmt->execute([$id, $userId]);
        return true;
    }
}
