<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Service extends Model implements Sortable
{
    use SortableTrait;

    protected $table = 'services';
    public array $sortable = [
        'order_column_name' => 'position',
        'sort_when_creating' => true,
    ];

    public function buildSortQuery(): Builder
    {
        return static::query()
            ->where('parent_id', $this->parent_id);
    }

    protected $fillable = [
        'title',
        'title_img',
        'slug',
        'body',
        'position',
        'parent_id',
        'is_active',
        'is_show_homepage',

        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_show_homepage' => 'boolean',
    ];

    private static function createTree(array $data, array $arr, array &$result = []): array
    {
        foreach ($arr as $item) {
            $node = $item;
            $itemId = $item['id'];
            $hasChildren = isset($data[$itemId]);

            if ($hasChildren) {
                $node['children'] = self::createTree($data, $data[$itemId]);
            }

            $result[] = $node;
        }
        return $result;
    }


    private static function createTreeSelect(array $data, int $level = null, array &$result = []):array
    {
        $level = $level !== null ? $level + 1 : 0;
        $beforeTitle = $level > 0 ? str_repeat('— ', $level) : '';
        foreach ($data as $item)
        {
            $result[$item['id']] = $beforeTitle . $item['title'];
            if (isset($item['children'])) {
                self::createTreeSelect($item['children'], $level, $result);
            }
        }
        return $result;
    }

    public static function toTreeSelect(): array
    {
        $tree = self::toTree();
        return self::createTreeSelect($tree);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'parent_id');
    }

    /**
     * @param array $tree дерево нод
     * @param int $searchId Искомый идентификатор
     * @return int|null корневой элемент дерева, если он есть
     */
    public static function findNodeRootId(int $searchId): ?int
    {
        $parentIdById = static::query()->pluck('parent_id', 'id')->toArray();
        if (!\in_array($searchId, \array_keys($parentIdById), true)) return null;
        return self::findNodeId($parentIdById, $searchId);
    }

    private static function findNodeId(array $parentIdById, int $searchId) : int
    {
        $nodeParentId = $parentIdById[$searchId];
        // is root
        if ($nodeParentId === null) return $searchId;
        return self::findNodeId($parentIdById, $nodeParentId);
    }

    public static function toTree(): array
    {
        $services = Service::query()
            ->where('is_active', '=', true)
            ->orderBy('position')
            ->select(['title', 'id', 'parent_id', 'slug'])
            ->get()
            ->toArray();

        $data = [];

        foreach ($services as $s) {
            $data[$s['parent_id'] ?? 0][] = $s;
        }

        $treeItems = self::createTree($data, $data[0] ?? []);

        return array_filter($treeItems, function ($item) {
            return $item['parent_id'] === null;
        });
    }

    public static function IsHasRecursion(int $id = null, int $newParentId = null):bool
    {
        // Если нет $parentId то нет рекурсии
        if (!$newParentId) return false;

        // Если ещё не в бд, то нет рекурсии
        if (!$id) return false;

        // Родитель не может быть "сам в себе"
        if ($id === $newParentId) return true;

        $fullTree = self::toTree();
        $nodeWithChildren = self::findChildById($fullTree, $id);
        // Если не нашлось
        if ($nodeWithChildren === null) return false;
        // Если нет детей, то нет рекурсии
        if (!isset($nodeWithChildren['children'])) return false;
        $existChild = self::findChildById($nodeWithChildren['children'], $newParentId);

        return $existChild !== null;
    }

    private static function findChildById(array $tree, int $searchId):?array
    {
        foreach ($tree as $node)
        {
            if ($node['id'] === $searchId) return $node;
            if (isset($item['children'])) {
                return self::findChildById($item['children'], $searchId);
            }
        }

        return null;
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $slug = $model->slug;
            if (empty($slug)) {
                $slug = $model->title;
            }

            $model->slug = Str::slug($slug);
        });
    }
}
