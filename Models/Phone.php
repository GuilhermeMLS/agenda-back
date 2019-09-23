<?php


class Phone extends Model
{
    /**
     * @param $user_id
     * @param $phone
     * @return null |null
     */
    public function create(
        $user_id,
        $phone
    ) {
        $sql = "
            INSERT INTO phones
                (`user_id`, `phone`, `created_at`, `updated_at`)
            VALUES
                (:user_id, :phone, :created_at, :updated_at)
        ";
        $req = Database::getBdd()->prepare($sql);
        $req->execute([
            'user_id' => $user_id,
            'phone' => $phone,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return null;
    }

    /**
     * @param $id
     * @param $phone
     * @return null |null
     */
    public function edit(
        $id,
        $phone
    ){
        $sql = "
            UPDATE phones SET
                `phone` = :phone,
                `updated_at` = :updated_at
            WHERE id = :id
        ";
        $req = Database::getBdd()->prepare($sql);
        $req->execute([
            'id' => $id,
            'phone' => $phone,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return null;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $sql = 'DELETE FROM phones WHERE id = ?';
        $req = Database::getBdd()->prepare($sql);

        return $req->execute([$id]);
    }
}
