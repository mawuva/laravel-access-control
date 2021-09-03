<?php

namespace Mawuekom\Accontrol\Persistables;

use Mawuekom\Accontrol\Traits\DataRecordsChecker;
use Mawuekom\Accontrol\Traits\ResourceDataManager;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Http\Response;
use Mawuekom\RepositoryLayer\BaseApiRepository;
use Mawuekom\RepositoryLayer\BaseRepository;

trait RoleManager
{
    use ResourceDataManager, DataRecordsChecker;

    /**
     * Create new role
     *
     * @param array $data
     *
     * @return array
     */
    public function createRole(array $data): array
    {
        $resource = config('accontrol.role.resource_name');
        $modelRepo = $this ->getModelRepo($resource);

        $this ->validateSlug($data['slug'], $resource);

        $insert = [
            'name'          => $data['name'],
            'slug'          => $data['slug'],
            'description'   => check_key_in_array($data, 'description'),
        ];

        $role = ($modelRepo instanceof BaseApiRepository || $modelRepo instanceof BaseRepository)
                        ? $modelRepo ->create($insert)
                        : $modelRepo::create($insert);

        return success_response(trans('accontrol::messages.entity.created', [
            'Entity' => trans_choice('accontrol::entity.role', 1)
        ]), $role);
    }

    /**
     * Get all roles
     * 
     * @param boolean $paginate
     * 
     * @return array
     */
    public function getRoles($paginate = true): array
    {
        $resource = config('accontrol.role.resource_name');
        $modelRepo = $this ->getModelRepo($resource);

        if ($modelRepo instanceof BaseApiRepository) {
            $roles = (!$paginate)
                                ? $modelRepo ->getAllResources()
                                : $modelRepo ->paginateAllResources();
        }

        else {
            $roles = (!$paginate)
                                ? $modelRepo ->all()
                                : $modelRepo ->paginate(20);
        }

        $this ->checkDataRecords($roles, trans('accontrol::messages.records.not_available'));

        return success_response(trans('accontrol::messages.entity.list', [
            'Entity' => trans_choice('accontrol::entity.role', 1)
        ]), $roles);
    }
    
    /**
     * Retrieve trashed roles
     * 
     * @return array
     */
    public function getDeletedRoles(): array
    {
        $resource = config('accontrol.role.resource_name');
        $roles = config('accontrol.'.$resource.'.model')::onlyTrashed() ->get();

        $this ->checkDataRecords($roles, trans('accontrol::messages.records.not_found_trashed'));

        return success_response(trans('accontrol::messages.entity.deleted_list', [
            'Entity' => trans_choice('accontrol::entity.role', 1)
        ]), $roles);
    }

    /**
     * Search role 
     * 
     * @param string $searchTerm
     * 
     * @return array
     */
    public function searchRoles(string $searchTerm, $paginate = false): array
    {
        $resource = config('accontrol.role.resource_name');
        $modelRepo = $this ->getModelRepo($resource);

        if ($modelRepo instanceof BaseApiRepository) {
            $roles = (!$paginate)
                                ? $modelRepo ->searchResources($searchTerm)
                                : $modelRepo ->paginateSearchResources($searchTerm);
        }

        else {
            $roles = (!$paginate)
                                ? $modelRepo ->whereLike(['name', 'slug'], $searchTerm)
                                : $modelRepo ->whereLike(['name', 'slug'], $searchTerm) ->paginate(20);
        }

        if ($roles ->count() == 0) {
            throw new RecordsNotFoundException(trans('accontrol::messages.no_results_found'), Response::HTTP_NOT_FOUND);
        }

        return success_response(trans('accontrol::messages.entity.search_results', [
            'Entity' => trans_choice('accontrol::entity.role', 1)
        ]), $roles);
    }

    /**
     * Get role by ID
     * 
     * @param int|string $role_id
     * @param boolean $deleted
     * 
     * @return array
     */
    public function getRole($role_id, $deleted = false): array
    {
        $resource = config('accontrol.role.resource_name');
        $role = $this ->validateAndGetResourceById($role_id, $resource, $deleted);

        return success_response(trans('accontrol::messages.entity.resource', [
            'Entity' => trans_choice('accontrol::entity.role', 1)
        ]), $role);
    }

    /**
     * Get role by slug
     * 
     * @param string $slug
     * 
     * @return array
     */
    public function getRoleBySlug(string $slug): array
    {
        $resource = config('accontrol.role.resource_name');
        $role = $this ->validateAndGetResourceBySlug($slug, $resource);

        return success_response(trans('accontrol::messages.entity.resource', [
            'Entity' => trans_choice('accontrol::entity.role', 1)
        ]), $role);
    }

    /**
     * Update role data
     * 
     * @param int|string $role_id
     * @param array $data
     * 
     * @return array
     */
    public function updateRole(int|string $role_id, array $data): array
    {
        $resource = config('accontrol.role.resource_name');
        $role = $this ->validateAndGetResourceById($role_id, $resource);

        $this ->validateSlug($data['slug'], $resource, $role ->id);

        $role ->update([
            'name'          => $data['name'],
            'slug'          => $data['slug'],
            'description'   => check_key_in_array($data, 'description'),
        ]);

        return success_response(trans('accontrol::messages.entity.updated', [
            'Entity' => trans_choice('accontrol::entity.role', 1)
        ]), $role);
    }

    /**
     * Delete role
     * 
     * @param int|string $role_id
     * 
     * @return array
     */
    public function deleteRole(int|string $role_id): array
    {
        $resource = config('accontrol.role.resource_name');
        $role = $this ->validateAndGetResourceById($role_id, $resource);
        $role ->delete();

        return success_response(trans('accontrol::messages.entity.deleted', [
            'Entity' => trans_choice('accontrol::entity.role', 1)
        ]), $role);
    }

    /**
     * Restore role account
     * 
     * @param int|string $role_id
     * 
     * @return array
     */
    public function restoreRole(int|string $role_id): array
    {
        $resource = config('accontrol.role.resource_name');
        $role = $this ->validateAndGetResourceById($role_id, $resource, true);
        $role ->restore();

        return success_response(trans('accontrol::messages.entity.restored', [
            'Entity' => trans_choice('accontrol::entity.role', 1)
        ]), $role);
    }

    /**
     * Delete role permanently
     * 
     * @param int|string $role_id
     * 
     * @return array
     */
    public function destroyRole(int|string $role_id): array
    {
        $resource = config('accontrol.role.resource_name');
        $role = $this ->validateAndGetResourceById($role_id, $resource, true);
        $role ->forceDelete();

        return success_response(trans('accontrol::messages.entity.deleted_permanently', [
            'Entity' => trans_choice('accontrol::entity.role', 1)
        ]), null);
    }
}