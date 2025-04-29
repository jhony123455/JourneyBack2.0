<?php

namespace App\Services;

use App\Interfaces\TagRepositoryInterface;

class TagService
{
    protected $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function getAll()
    {
        return $this->tagRepository->getAll();
    }

    public function getById($id)
    {
        return $this->tagRepository->findById($id);
    }

    public function create(array $data)
    {
        return $this->tagRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->tagRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->tagRepository->delete($id);
    }
}
