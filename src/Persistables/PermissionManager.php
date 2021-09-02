<?php

namespace Accontrol\Persistables;

use Accontrol\Traits\DataRecordsChecker;
use Accontrol\Traits\ResourceDataManager;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Http\Response;
use Mawuekom\RepositoryLayer\BaseApiRepository;
use Mawuekom\RepositoryLayer\BaseRepository;

trait PermissionManager
{
    use ResourceDataManager, DataRecordsChecker;

    /**
     * Create new permission
     *
     * @param array $data
     *
     * @return array
     */
    public function createPermission(array $data): array
    {
        $resource = config('accontrol.permission.resource_name');
        $modelRepo = $this ->getModelRepo($resource);

        $this ->validateSlug($data['slug'], $resource);

        $insert = [
            'name'          => $data['name'],
            'slug'          => $data['slug'],
            'description'   => check_key_in_array($data, 'description'),
            'entity_id'     => check_key_in_array($data, 'entity_id'),
        ];

        $permission = ($modelRepo instanceof BaseApiRepository || $modelRepo instanceof BaseRepository)
                        ? $modelRepo ->create($insert)
                        : $modelRepo::create($insert);

        return success_response(trans('accontrol::messages.entity.created', [
            'Entity' => trans_choice('accontrol::entity.permission', 1)
        ]), $permission);
    }

    /**
     * Get all permissions
     * 
     * @param boolean $paginate
     * 
     * @return array
     */
    public function getPermissions($paginate = true): array
    {
        $resource = config('accontrol.permission.resource_name');
        $modelRepo = $this ->getModelRepo($resource);

        if ($modelRepo instanceof BaseApiRepository) {
            $permissions = (!$paginate)
                                ? $modelRepo ->getAllResources()
                                : $modelRepo ->paginateAllResources();
        }

        else {
            $permissions = (!$paginate)
                                ? $modelRepo ->all()
                                : $modelRepo ->paginate(20);
        }

        $this ->checkDataRecords($permissions, trans('accontrol::messages.records.not_available'));

        return success_response(trans('accontrol::messages.entity.list', [
            'Entity' => trans_choice('accontrol::entity.permission', 1)
        ]), $permissions);
    }
    
    /**
     * Retrieve trashed permissions
     * 
     * @return array
     */
    public function getDeletedPermissions(): array
    {
        $resource = config('accontrol.permission.resource_name');
        $permissions = config('accontrol.'.$resource.'.model')::onlyTrashed() ->get();

        $this ->checkDataRecords($permissions, trans('accontrol::messages.records.not_found_trashed'));

        return success_response(trans('accontrol::messages.entity.deleted_list', [
            'Entity' => trans_choice('accontrol::entity.permission', 1)
        ]), $permissions);
    }

    /**
     * Search permission 
     * 
     * @param string $searchTerm
     * 
     * @return array
     */
    public function searchPermissions(string $searchTerm, $paginate = false): array
    {
        $resource = config('accontrol.permission.resource_name');
        $modelRepo = $this ->getModelRepo($resource);

        if ($modelRepo instanceof BaseApiRepository) {
            $permissions = (!$paginate)
                                ? $modelRepo ->searchResources($searchTerm)
                                : $modelRepo ->paginateSearchResources($searchTerm);
        }

        else {
            $permissions = (!$paginate)
                                ? $modelRepo ->whereLike(['name', 'slug'], $searchTerm)
                                : $modelRepo ->whereLike(['name', 'slug'], $searchTerm) ->paginate(20);
        }

        if ($permissions ->count() == 0) {
            throw new RecordsNotFoundException(trans('accontrol::messages.no_results_found'), Response::HTTP_NOT_FOUND);
        }

        return success_response(trans('accontrol::messages.entity.search_results', [
            'Entity' => trans_choice('accontrol::entity.permission', 1)
        ]), $permissions);
    }

    /**
     * Get permission by ID
     * 
     * @param int|string $permission_id
     * @param boolean $deleted
     * 
     * @return array
     */
    public function getPermission($permission_id, $deleted = false): array
    {
        $resource = config('accontrol.permission.resource_name');
        $permission = $this ->validateAndGetResourceById($permission_id, $resource, $deleted);

        return success_response(trans('accontrol::messages.entity.resource', [
            'Entity' => trans_choice('accontrol::entity.permission', 1)
        ]), $permission);
    }

    /**
     * Get permission by slug
     * 
     * @param string $slug
     * 
     * @return array
     */
    public function getPermissionBySlug(string $slug): array
    {
        $resource = config('accontrol.permission.resource_name');
        $permission = $this ->validateAndGetResourceBySlug($slug, $resource);

        return success_response(trans('accontrol::messages.entity.resource', [
            'Entity' => trans_choice('accontrol::entity.permission', 1)
        ]), $permission);
    }

    /**
     * Update permission data
     * 
     * @param int|string $permission_id
     * @param array $data
     * 
     * @return array
     */
    public function updatePermission(int|string $permission_id, array $data): array
    {
        $resource = config('accontrol.permission.resource_name');
        $permission = $this ->validateAndGetResourceById($permission_id, $resource);

        $this ->validateSlug($data['slug'], $resource, $permission ->id);

        $permission ->update([
            'name'          => $data['name'],
            'slug'          => $data['slug'],
            'description'   => check_key_in_array($data, 'description'),
            'entity_id'     => check_key_in_array($data, 'entity_id'),
        ]);

        return success_response(trans('accontrol::messages.entity.updated', [
            'Entity' => trans_choice('accontrol::entity.permission', 1)
        ]), $permission);
    }

    /**
     * Delete role
     * 
     * @param int|string $permission_id
     * 
     * @return array
     */
    public function deletePermission(int|string $permission_id): array
    {
        $resource = config('accontrol.permission.resource_name');
        $permission = $this ->validateAndGetResourceById($permission_id, $resource);
        $permission ->delete();

        return success_response(trans('accontrol::messages.entity.deleted', [
            'Entity' => trans_choice('accontrol::entity.permission', 1)
        ]), $permission);
    }

    /**
     * Restore permission account
     * 
     * @param int|string $permission_id
     * 
     * @return array
     */
    public function restorePermission(int|string $permission_id): array
    {
        $resource = config('accontrol.permission.resource_name');
        $permission = $this ->validateAndGetResourceById($permission_id, $resource, true);
        $permission ->restore();

        return success_response(trans('accontrol::messages.entity.restored', [
            'Entity' => trans_choice('accontrol::entity.permission', 1)
        ]), $permission);
    }

    /**
     * Delete permission permanently
     * 
     * @param int|string $permission_id
     * 
     * @return array
     */
    public function destroyPermission(int|string $permission_id): array
    {
        $resource = config('accontrol.permission.resource_name');
        $permission = $this ->validateAndGetResourceById($permission_id, $resource, true);
        $permission ->forceDelete();

        return success_response(trans('accontrol::messages.entity.deleted_permanently', [
            'Entity' => trans_choice('accontrol::entity.permission', 1)
        ]), null);
    }
}