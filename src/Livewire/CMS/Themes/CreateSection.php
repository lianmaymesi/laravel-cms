<?php

namespace Lianmaymesi\LaravelCms\Livewire\CMS\Themes;

use Psy\Output\Theme;
use Livewire\Attributes\Layout;
use Lianmaymesi\LaravelCms\Livewire\BaseComponent;

#[Layout('components.marketing.layouts.admin')]
class CreateSection extends BaseComponent
{
    public $page_title = 'Create Section';

    public $title;
    public $theme_id;
    public $subSection = [];
    public $settings = [
        'screens' => [
            'sm' => 1,
            'md' => 2,
            'lg' => 4,
            'xl' => 0,
            '2xl' => 0
        ]
    ];
    public $skeletonValues;
    public $config = [];
    public $bladeFiles = [];
    public $section_file;

    public function addColumn()
    {
        $this->subSection[] = [
            'id' => count($this->subSection) + 1,
            'skeleton' => []
        ];
    }

    public function removeColumn($index)
    {
        unset($this->subSection[$index]);
        $this->subSection = array_values($this->subSection);
    }

    public function addValue($key, $columnIndex)
    {
        $val = [$this->skeletonValues];
        $valM = collect($this->subSection)->map(function ($section) use ($columnIndex, $val) {
            if ($section['id'] == $columnIndex) {
                $section['skeleton'] = array_merge($section['skeleton'], $val);
            }
            return $section;
        })->toArray();
        $this->subSection[$key] = $valM[$key];
        $this->transformArray($key);
    }

    public function transformArray($key)
    {
        $valuesCount = [];

        // First count all occurrences of each value type
        foreach ($this->subSection[$key]['skeleton'] as $item) {
            $baseItem = preg_replace('/_\d+$/', '', $item);
            if (!isset($valuesCount[$baseItem])) {
                $valuesCount[$baseItem] = 0;
            } else {
                $valuesCount[$baseItem]++;
            }
        }

        // Reset the count to start fresh
        $valuesCount = [];

        // Assign unique suffixes based on the updated counts
        $this->subSection[$key]['skeleton'] = array_map(function ($item) use (&$valuesCount) {
            $baseItem = preg_replace('/_\d+$/', '', $item);
            if (!isset($valuesCount[$baseItem])) {
                $valuesCount[$baseItem] = 0;
            } else {
                $valuesCount[$baseItem]++;
            }
            return $baseItem . '_' . $valuesCount[$baseItem];
        }, $this->subSection[$key]['skeleton']);
    }

    public function removeValue($columnIndex, $valueIndex)
    {
        unset($this->subSection[$columnIndex][$valueIndex]);
        $this->subSection[$columnIndex] = array_values($this->subSection[$columnIndex]);
    }

    public function updateSection($sectionIndex)
    {
        $orderMap = array_column($sectionIndex, 'order', 'value'); // Value is ID of the subsection
        $skelMap = array_column($this->subSection, 'skeleton', 'id');

        usort($this->subSection, function ($a, $b) use ($orderMap) {
            return $orderMap[$a['id']] <=> $orderMap[$b['id']];
        });

        $section = [];
        $i = 0;
        foreach ($this->subSection as $item) {
            $section[] = [
                'id' => $i + 1,
                'skeleton' => $item['skeleton']
            ];
            $i++;
        }
        $this->subSection = $section;
    }

    public function mergeModelData($array1, $array2)
    {
        foreach ($array2 as $id => $modelData) {
            foreach ($array1 as &$item) {
                if ($item['id'] === $id) {
                    $item['skeleton'] = $modelData;
                    break;
                }
            }
        }

        return $array1;
    }

    public function updateSkeleton($items)
    {
        $orderMap = [];

        foreach ($items as $sectionOrder) {
            $sectionId = $sectionOrder['value'];
            $orderMap[$sectionId] = array_column($sectionOrder['items'], 'order', 'value');
        }

        foreach ($this->subSection as &$section) {
            $sectionId = $section['id'];
            if (isset($orderMap[$sectionId])) {
                usort($section['skeleton'], function ($a, $b) use ($orderMap, $sectionId) {
                    $orderA = $orderMap[$sectionId][$a] ?? PHP_INT_MAX;
                    $orderB = $orderMap[$sectionId][$b] ?? PHP_INT_MAX;
                    return $orderA <=> $orderB;
                });
            }
        }
    }

    public function updatedThemeId($theme)
    {
        $directory = resource_path('views/components/user/themes/' . Theme::where('id', $theme)->first()->slug);

        $this->bladeFiles = collect(File::files($directory))
            ->filter(function ($file) {
                return $file->getExtension() === 'php';
            })
            ->map(function ($file) {
                return str_replace('.blade.php', '', $file->getFilename());
            })->toArray();
    }

    public function create()
    {
        $data = $this->validate([
            'title' => 'required|string',
            'theme_id' => 'required|exists:themes,id',
            'subSection' => 'required|array',
            'settings' => 'required|array',
            'section_file' => 'required'
        ]);

        DB::transaction(function () use ($data) {

            $section = Section::create([
                'title' => $data['title'],
                'theme_id' => $data['theme_id'],
                'section_file' => $data['section_file']
            ]);

            $section->skeleton()->create([
                'skeleton' => json_encode(array_merge(
                    [
                        'data' => $this->mergeModelData($data['subSection'], $this->config)
                    ],
                    [
                        'settings' => $data['settings']
                    ]
                ))
            ]);
        });

        $this->reset();
    }

    #[Computed()]
    public function themes()
    {
        return Theme::get();
    }

    #[Computed()]
    public function allmodels()
    {
        $modelList = [];
        $path = app_path() . "/Models";
        $results = scandir($path);

        foreach ($results as $result) {
            if ($result === '.' or $result === '..') continue;

            // Check if it's a file
            if (is_file($path . '/' . $result)) {
                $model = "\App\\Models\\" . pathinfo($result, PATHINFO_FILENAME);

                // Check if the model has the WIDGET constant
                if (defined("$model::WIDGET") && $model::WIDGET) {
                    $modelList[] = pathinfo($result, PATHINFO_FILENAME);
                }
            }
        }

        return $modelList;
    }

    public function render()
    {
        return view('livewire.marketing.c-m-s.themes.create-section');
    }
}
