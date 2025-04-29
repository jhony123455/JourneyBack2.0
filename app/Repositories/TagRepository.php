<?php

namespace App\Repositories;

use App\Interfaces\TagRepositoryInterface;
use App\Models\Tag;

class TagRepository implements TagRepositoryInterface
{
    public function getAll()
    {
        return Tag::all();
    }

    public function findById($id)
    {
        return Tag::findOrFail($id);
    }

    public function create(array $data)
    {
        return Tag::create($data);
    }

    public function update($id, array $data)
    {
        $tag = $this->findById($id);
        $tag->update($data);
        return $tag;
    }

    public function delete($id)
    {
        $tag = $this->findById($id);
        $tag->delete();
    }
}
