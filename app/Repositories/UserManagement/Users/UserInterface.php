<?php
namespace App\Repositories\UserManagement\Users;

Interface UserInterface{
    public function storeUser($data);
    public function findUser($id);
    public function updateUser($data, $id);
    public function destroyUser($id);
    public function statusUser($data);
}
