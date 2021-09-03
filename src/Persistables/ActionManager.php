<?php

namespace Mawuekom\Accontrol\Persistables;

use Mawuekom\Accontrol\Traits\DataRecordsChecker;
use Mawuekom\Accontrol\Traits\ResourceDataManager;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Http\Response;
use Mawuekom\RepositoryLayer\BaseApiRepository;
use Mawuekom\RepositoryLayer\BaseRepository;

trait ActionManager
{
    use ResourceDataManager, DataRecordsChecker;

    /**
     * Create new action
     *
     * @param array $data
     *
     * @return array
     */
    public function createAction(array $data): array
    {
        $resource = config('accontrol.action.resource_name');
        $modelRepo = $this ->getModelRepo($resource);

        $this ->validateSlug($data['slug'], $resource);

        $available_for_all_entities = (isset($data['available_for_all_entities']) && !empty($data['available_for_all_entities']))
                                        ? ['available_for_all_entities' =>1]
                                        : [];

        $insert = array_merge($available_for_all_entities, [
            'name'          => $data['name'],
            'slug'          => $data['slug'],
            'description'   => check_key_in_array($data, 'description'),
        ]);

        $action = ($modelRepo instanceof BaseApiRepository || $modelRepo instanceof BaseRepository)
                        ? $modelRepo ->create($insert)
                        : $modelRepo::create($insert);

        return success_response(trans('accontrol::messages.entity.created', [
            'Entity' => trans_choice('accontrol::entity.action', 1)
        ]), $action);
    }

    /**
     * Get all actions
     * 
     * @param boolean $paginate
     * 
     * @return array
     */
    public function getActions($paginate = true): array
    {
        $resource = config('accontrol.action.resource_name');
        $modelRepo = $this ->getModelRepo($resource);

        if ($modelRepo instanceof BaseApiRepository) {
            $actions = (!$paginate)
                                ? $modelRepo ->getAllResources()
                                : $modelRepo ->paginateAllResources();
        }

        else {
            $actions = (!$paginate)
                                ? $modelRepo ->all()
                                : $modelRepo ->paginate(20);
        }

        $this ->checkDataRecords($actions, trans('accontrol::messages.records.not_available'));

        return success_response(trans('accontrol::messages.entity.list', [
            'Entity' => trans_choice('accontrol::entity.action', 1)
        ]), $actions);
    }
    
    /**
     * Retrieve trashed actions
     * 
     * @return array
     */
    public function getDeletedActions(): array
    {
        $resource = config('accontrol.action.resource_name');
        $actions = config('accontrol.'.$resource.'.model')::onlyTrashed() ->get();

        $this ->checkDataRecords($actions, trans('accontrol::messages.records.not_found_trashed'));

        return success_response(trans('accontrol::messages.entity.deleted_list', [
            'Entity' => trans_choice('accontrol::entity.action', 1)
        ]), $actions);
    }

    /**
     * Search action 
     * 
     * @param string $searchTerm
     * 
     * @return array
     */
    public function searchActions(string $searchTerm, $paginate = false): array
    {
        $resource = config('accontrol.action.resource_name');
        $modelRepo = $this ->getModelRepo($resource);

        if ($modelRepo instanceof BaseApiRepository) {
            $actions = (!$paginate)
                                ? $modelRepo ->searchResources($searchTerm)
                                : $modelRepo ->paginateSearchResources($searchTerm);
        }

        else {
            $actions = (!$paginate)
                                ? $modelRepo ->whereLike(['name', 'slug'], $searchTerm)
                                : $modelRepo ->whereLike(['name', 'slug'], $searchTerm) ->paginate(20);
        }

        if ($actions ->count() == 0) {
            throw new RecordsNotFoundException(trans('accontrol::messages.no_results_found'), Response::HTTP_NOT_FOUND);
        }

        return success_response(trans('accontrol::messages.entity.search_results', [
            'Entity' => trans_choice('accontrol::entity.action', 1)
        ]), $actions);
    }

    /**
     * Get action by ID
     * 
     * @param int|string $action_id
     * @param boolean $deleted
     * 
     * @return array
     */
    public function getAction($action_id, $deleted = false): array
    {
        $resource = config('accontrol.action.resource_name');
        $action = $this ->validateAndGetResourceById($action_id, $resource, $deleted);

        return success_response(trans('accontrol::messages.entity.resource', [
            'Entity' => trans_choice('accontrol::entity.action', 1)
        ]), $action);
    }

    /**
     * Get action by slug
     * 
     * @param string $slug
     * 
     * @return array
     */
    public function getActionBySlug(string $slug): array
    {
        $resource = config('accontrol.action.resource_name');
        $action = $this ->validateAndGetResourceBySlug($slug, $resource);

        return success_response(trans('accontrol::messages.entity.resource', [
            'Entity' => trans_choice('accontrol::entity.action', 1)
        ]), $action);
    }

    /**
     * Update action data
     * 
     * @param int|string $action_id
     * @param array $data
     * 
     * @return array
     */
    public function updateAction(int|string $action_id, array $data): array
    {
        $resource = config('accontrol.action.resource_name');
        $action = $this ->validateAndGetResourceById($action_id, $resource);

        $this ->validateSlug($data['slug'], $resource, $action ->id);

        $available_for_all_entities = (isset($data['available_for_all_entities']) && !empty($data['available_for_all_entities']))
                                        ? ['available_for_all_entities' =>1]
                                        : [];

        $datas = array_merge($available_for_all_entities, [
            'name'          => $data['name'],
            'slug'          => $data['slug'],
            'description'   => check_key_in_array($data, 'description'),
        ]);

        $action ->update($datas);

        return success_response(trans('accontrol::messages.entity.updated', [
            'Entity' => trans_choice('accontrol::entity.action', 1)
        ]), $action);
    }

    /**
     * Delete role
     * 
     * @param int|string $action_id
     * 
     * @return array
     */
    public function deleteAction(int|string $action_id): array
    {
        $resource = config('accontrol.action.resource_name');
        $action = $this ->validateAndGetResourceById($action_id, $resource);
        $action ->delete();

        return success_response(trans('accontrol::messages.entity.deleted', [
            'Entity' => trans_choice('accontrol::entity.action', 1)
        ]), $action);
    }

    /**
     * Restore action account
     * 
     * @param int|string $action_id
     * 
     * @return array
     */
    public function restoreAction(int|string $action_id): array
    {
        $resource = config('accontrol.action.resource_name');
        $action = $this ->validateAndGetResourceById($action_id, $resource, true);
        $action ->restore();

        return success_response(trans('accontrol::messages.entity.restored', [
            'Entity' => trans_choice('accontrol::entity.action', 1)
        ]), $action);
    }

    /**
     * Delete action permanently
     * 
     * @param int|string $action_id
     * 
     * @return array
     */
    public function destroyAction(int|string $action_id): array
    {
        $resource = config('accontrol.action.resource_name');
        $action = $this ->validateAndGetResourceById($action_id, $resource, true);
        $action ->forceDelete();

        return success_response(trans('accontrol::messages.entity.deleted_permanently', [
            'Entity' => trans_choice('accontrol::entity.action', 1)
        ]), null);
    }
}