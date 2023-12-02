<?php

namespace App\Interfaces\Book;

interface BookRepositoryInterface
{
    public function all($paginate = null, $page = null, $limit = null);
    public function find($id);
    public function create($data);
    public function update($data, $id);
    public function delete($id);
}
