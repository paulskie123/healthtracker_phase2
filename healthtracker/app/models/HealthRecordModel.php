<?php
require_once APP_PATH . '/models/Model.php';

class HealthRecordModel extends Model {

    public function getAll($userId = 1) {
        $stmt = $this->db->prepare(
            'SELECT * FROM health_records WHERE user_id = ? ORDER BY date DESC, id DESC'
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function findById($id, $userId = 1) {
        $stmt = $this->db->prepare(
            'SELECT * FROM health_records WHERE id = ? AND user_id = ? LIMIT 1'
        );
        $stmt->execute([$id, $userId]);
        return $stmt->fetch() ?: null;
    }

    public function add($record, $userId = 1) {
        $stmt = $this->db->prepare(
            'INSERT INTO health_records
             (user_id, date, systolic_bp, diastolic_bp, heart_rate, weight, blood_sugar, notes)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $userId,
            $record['date'],
            $record['systolic_bp'],
            $record['diastolic_bp'],
            $record['heart_rate'],
            $record['weight'],
            $record['blood_sugar'],
            $record['notes'] ?? '',
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update($id, $record, $userId = 1) {
        $stmt = $this->db->prepare(
            'UPDATE health_records
             SET date=?, systolic_bp=?, diastolic_bp=?, heart_rate=?, weight=?, blood_sugar=?, notes=?
             WHERE id=? AND user_id=?'
        );
        $stmt->execute([
            $record['date'],
            $record['systolic_bp'],
            $record['diastolic_bp'],
            $record['heart_rate'],
            $record['weight'],
            $record['blood_sugar'],
            $record['notes'] ?? '',
            $id,
            $userId,
        ]);
        return true;
    }

    public function delete($id, $userId = 1) {
        $stmt = $this->db->prepare(
            'DELETE FROM health_records WHERE id = ? AND user_id = ?'
        );
        $stmt->execute([$id, $userId]);
        return true;
    }
}
