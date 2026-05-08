<?php
require_once APP_PATH . '/models/Model.php';

class AppointmentModel extends Model {

    public function getAll($userId = 1) {
        $stmt = $this->db->prepare(
            'SELECT * FROM appointments WHERE user_id = ? ORDER BY date DESC, time DESC'
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function findById($id, $userId = 1) {
        $stmt = $this->db->prepare(
            'SELECT * FROM appointments WHERE id = ? AND user_id = ? LIMIT 1'
        );
        $stmt->execute([$id, $userId]);
        return $stmt->fetch() ?: null;
    }

    public function add($data, $userId = 1) {
        $stmt = $this->db->prepare(
            'INSERT INTO appointments
             (user_id, doctor, specialty, date, time, location, type, status, notes)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $userId,
            $data['doctor'],
            $data['specialty'],
            $data['date'],
            $data['time'],
            $data['location'] ?? '',
            $data['type']     ?? 'Check-up',
            $data['status']   ?? 'Scheduled',
            $data['notes']    ?? '',
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update($id, $data, $userId = 1) {
        $stmt = $this->db->prepare(
            'UPDATE appointments
             SET doctor=?, specialty=?, date=?, time=?, location=?, type=?, status=?, notes=?
             WHERE id=? AND user_id=?'
        );
        $stmt->execute([
            $data['doctor'],
            $data['specialty'],
            $data['date'],
            $data['time'],
            $data['location'] ?? '',
            $data['type']     ?? 'Check-up',
            $data['status']   ?? 'Scheduled',
            $data['notes']    ?? '',
            $id,
            $userId,
        ]);
        return true;
    }

    public function delete($id, $userId = 1) {
        $stmt = $this->db->prepare(
            'DELETE FROM appointments WHERE id = ? AND user_id = ?'
        );
        $stmt->execute([$id, $userId]);
        return true;
    }
}
