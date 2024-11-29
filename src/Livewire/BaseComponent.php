<?php

namespace Lianmaymesi\LaravelCms\Livewire;

use Livewire\Component;

abstract class BaseComponent extends Component
{
    public $sortDirection = 'asc';

    public $sortField = 'updated_at';

    protected $queryString = ['sortField', 'sortDirection'];

    public $selected_id;

    public $perPage = '10';

    public array $selectedColumns = [];

    public array $columns = [];

    public $selectedRow = [];

    public $selectAllRow = false;

    public string $search = '';

    public $showDeleteModal = false;

    public array $filters = [];

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortField = $field;
    }

    public function trig($type, $id)
    {
        $type === 'delete' ? $this->selected_id = $id : null;
        $this->showDeleteModal = true;
        $this->milkdown = '**Header**';
    }

    public function close()
    {
        $this->reset('selected_id');
    }

    public function showColumn($value)
    {
        return ! in_array($value, $this->selectedColumns);
    }

    public function updatedSelectAllRow($value)
    {
        $this->selectedRow = $value
            ? $this->thisPageQuery->pluck('id')->map(fn ($id) => (string) $id)
            : [];
    }

    public function getThisPageQueryProperty()
    {
        return [];
    }

    public function render()
    {
        return '';
    }
}