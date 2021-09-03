<?php

namespace Accontrol\Persistables;

use Accontrol\Traits\DataRecordsChecker;
use Accontrol\Traits\ResourceDataManager;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Http\Response;
use Mawuekom\RepositoryLayer\BaseApiRepository;
use Mawuekom\RepositoryLayer\BaseRepository;

trait EntityManager
{
    use ResourceDataManager, DataRecordsChecker;

    /**
     * Create new entity
     *
     * @param array $data
     *
     * @return array
     */
    public function createEntity(array $data): array
    {
        $resource = config('accontrol.entity.resource_name');
        $modelRepo = $this ->getModelRepo($resource);

        $this ->validateSlug($data['slug'], $resource);

        $insert = [
            'name'          => $data['name'],
            'slug'          => $data['slug'],
            'model'         => check_key_in_array($data, 'model'),
            'description'   => check_key_in_array($data, 'description'),
        ];

        $entity = ($modelRepo instanceof BaseApiRepository || $modelRepo instanceof BaseRepository)
                        ? $modelRepo ->create($insert)
                        : $modelRepo::create($insert);

        return success_response(trans('accontrol::messages.entity.created', [
            'Entity' => trans_choice('accontrol::entity.entity', 1)
        ]), $entity);
    }

    /**
     * Get all entities
     * 
     * @param boolean $paginate
     * 
     * @return array
     */
    public function getEntities($paginate = true): array
    {
        $resource = config('accontrol.entity.resource_name');
        $modelRepo = $this ->getModelRepo($resource);

        if ($modelRepo instanceof BaseApiRepository) {
            $entities = (!$paginate)
                                ? $modelRepo ->getAllResources()
                                : $modelRepo ->paginateAllResources();
        }

        else {
            $entities = (!$paginate)
                                ? $modelRepo ->all()
                                : $modelRepo ->paginate(20);
        }

        $this ->checkDataRecords($entities, trans('accontrol::messages.records.not_available'));

        return success_response(trans('accontrol::messages.entity.list', [
            'Entity' => trans_choice('accontrol::entity.entity', 1)
        ]), $entities);
    }
    
    /**
     * Retrieve trashed entities
     * 
     * @return array
     */
    public function getDeletedEntities(): array
    {
        $resource = config('accontrol.entity.resource_name');
        $entities = config('accontrol.'.$resource.'.model')::onlyTrashed() ->get();

        $this ->checkDataRecords($entities, trans('accontrol::messages.records.not_found_trashed'));

        return success_response(trans('accontrol::messages.entity.deleted_list', [
            'Entity' => trans_choice('accontrol::entity.entity', 1)
        ]), $entities);
    }

    /**
     * Search entity 
     * 
     * @param string $searchTerm
     * 
     * @return array
     */
    public function searchEntities(string $searchTerm, $paginate = false): array
    {
        $resource = config('accontrol.entity.resource_name');
        $modelRepo = $this ->getModelRepo($resource);

        if ($modelRepo instanceof BaseApiRepository) {
            $entities = (!$paginate)
                                ? $modelRepo ->searchResources($searchTerm)
                                : $modelRepo ->paginateSearchResources($searchTerm);
        }

        else {
            $entities = (!$paginate)
                                ? $modelRepo ->whereLike(['name', 'slug'], $searchTerm)
                                : $modelRepo ->whereLike(['name', 'slug'], $searchTerm) ->paginate(20);
        }

        if ($entities ->count() == 0) {
            throw new RecordsNotFoundException(trans('accontrol::messages.no_results_found'), Response::HTTP_NOT_FOUND);
        }

        return success_response(trans('accontrol::messages.entity.search_results', [
            'Entity' => trans_choice('accontrol::entity.entity', 1)
        ]), $entities);
    }

    /**
     * Get entity by ID
     * 
     * @param int|string $entity_id
     * @param boolean $deleted
     * 
     * @return array
     */
    public function getEntity($entity_id, $deleted = false): array
    {
        $resource = config('accontrol.entity.resource_name');
        $entity = $this ->validateAndGetResourceById($entity_id, $resource, $deleted);

        return success_response(trans('accontrol::messages.entity.resource', [
            'Entity' => trans_choice('accontrol::entity.entity', 1)
        ]), $entity);
    }

    /**
     * Get entity by slug
     * 
     * @param string $slug
     * 
     * @return array
     */
    public function getEntityBySlug(string $slug): array
    {
        $resource = config('accontrol.entity.resource_name');
        $entity = $this ->validateAndGetResourceBySlug($slug, $resource);

        return success_response(trans('accontrol::messages.entity.resource', [
            'Entity' => trans_choice('accontrol::entity.entity', 1)
        ]), $entity);
    }

    /**
     * Update entity data
     * 
     * @param int|string $entity_id
     * @param array $data
     * 
     * @return array
     */
    public function updateEntity(int|string $entity_id, array $data): array
    {
        $resource = config('accontrol.entity.resource_name');
        $entity = $this ->validateAndGetResourceById($entity_id, $resource);

        $this ->validateSlug($data['slug'], $resource, $entity ->id);

        $entity ->update([
            'name'          => $data['name'],
            'slug'          => $data['slug'],
            'model'         => check_key_in_array($data, 'model'),
            'description'   => check_key_in_array($data, 'description'),
        ]);

        return success_response(trans('accontrol::messages.entity.updated', [
            'Entity' => trans_choice('accontrol::entity.entity', 1)
        ]), $entity);
    }

    /**
     * Delete role
     * 
     * @param int|string $entity_id
     * 
     * @return array
     */
    public function deleteEntity(int|string $entity_id): array
    {
        $resource = config('accontrol.entity.resource_name');
        $entity = $this ->validateAndGetResourceById($entity_id, $resource);
        $entity ->delete();

        return success_response(trans('accontrol::messages.entity.deleted', [
            'Entity' => trans_choice('accontrol::entity.entity', 1)
        ]), $entity);
    }

    /**
     * Restore entity account
     * 
     * @param int|string $entity_id
     * 
     * @return array
     */
    public function restoreEntity(int|string $entity_id): array
    {
        $resource = config('accontrol.entity.resource_name');
        $entity = $this ->validateAndGetResourceById($entity_id, $resource, true);
        $entity ->restore();

        return success_response(trans('accontrol::messages.entity.restored', [
            'Entity' => trans_choice('accontrol::entity.entity', 1)
        ]), $entity);
    }

    /**
     * Delete entity permanently
     * 
     * @param int|string $entity_id
     * 
     * @return array
     */
    public function destroyEntity(int|string $entity_id): array
    {
        $resource = config('accontrol.entity.resource_name');
        $entity = $this ->validateAndGetResourceById($entity_id, $resource, true);
        $entity ->forceDelete();

        return success_response(trans('accontrol::messages.entity.deleted_permanently', [
            'Entity' => trans_choice('accontrol::entity.entity', 1)
        ]), null);
    }
}