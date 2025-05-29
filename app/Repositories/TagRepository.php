<?php

namespace App\Repositories;

use App\Interfaces\TagRepositoryInterface;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class TagRepository implements TagRepositoryInterface
{
    public function getAll()
    {
        return Tag::where('user_id', Auth::id())->get();
    }

    public function findById($id)
    {
        return Tag::where('user_id', Auth::id())->findOrFail($id);
    }

    public function create(array $data)
    {
        $data['user_id'] = Auth::id();
        return Tag::create($data);
    }

    public function update($id, array $data)
    {
        $tag = Tag::where('user_id', Auth::id())->findOrFail($id);
        $tag->update($data);
        return $tag;
    }

    public function delete($id)
    {
        $tag = Tag::where('user_id', Auth::id())->findOrFail($id);
        $tag->delete();
    }
}
