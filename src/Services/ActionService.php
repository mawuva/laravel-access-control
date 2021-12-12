<?php

namespace Mawuekom\Accontrol\Services;

use Illuminate\Http\Response;
use Mawuekom\Accontrol\Actions\SaveActionAction;
use Mawuekom\Accontrol\DataTransferObjects\ActionDTO;
use Mawuekom\Accontrol\Repositories\ActionRepository;

class ActionService
{
    /**
     * @var \Mawuekom\Accontrol\Repositories\ActionRepository
     */
    protected $actionRepository;

    /**
     * Create new service instance.
     *
     * @param \Mawuekom\Accontrol\Repositories\ActionRepository $actionRepository
     * 
     * @return void
     */
    public function __construct(actionRepository $actionRepository)
    {
        $this ->actionRepository  = $actionRepository;
    }

    /**
     * Return repository instance
     *
     * @return \Mawuekom\Accontrol\Repositories\ActionRepository
     */
    public function fromRepo()
    {
        return $this->actionRepository;
    }

    /**
     * Create new action.
     *
     * @param \Mawuekom\Accontrol\DataTransferObjects\ActionDTO $actionDTO
     *
     * @return array
     */
    public function create(ActionDTO $actionDTO): array
    {
        $action = app(SaveActionAction::class) ->execute($actionDTO);

        return success_response($action, trans('lang-resources::commons.messages.entity.created', [
            'Entity' => trans_choice('accontrol::entity.action', 1)
        ]), Response::HTTP_CREATED);
    }

    /**
     * Get action by ID
     * 
     * @param int|string $id
     * @param boolean $inTrashed
     * @param array $columns
     * 
     * @return array
     */
    public function getById($id, $inTrashed = false, $columns = ['*'])
    {
        $action = data_helpers($this ->actionRepository ->getModel(), [], $inTrashed)
                    ->fromId($id)
                    ->getDataRow($columns);

        if (is_null($action)) {
            return failure_response(null, trans('lang-resources::commons.messages.resource.not_found'), Response::HTTP_NO_CONTENT);
        }

        else {
            return success_response($action, trans('lang-resources::commons.messages.entity.resource', [
                'Entity' => trans_choice('accontrol::entity.action', 1)
            ]));
        }
    }

    /**
     * Get action by field
     * 
     * @param string $field
     * @param string $value
     * @param boolean $inTrashed
     * @param array $columns
     * 
     * @return array
     */
    public function getByField($field, $value = null, $inTrashed = false, $columns = ['*'])
    {
        $action = data_helpers($this ->actionRepository ->getModel(), [$field, $value], $inTrashed)
                    ->getDataRow($columns);

        if (is_null($action)) {
            return failure_response(null, trans('lang-resources::commons.messages.resource.not_found'), Response::HTTP_NO_CONTENT);
        }

        else {
            return success_response($action, trans('lang-resources::commons.messages.entity.resource', [
                'Entity' => trans_choice('accontrol::entity.action', 1)
            ]));
        }
    }

    /**
     * Update action data
     * 
     * @param int|string $id
     * @param \Mawuekom\Accontrol\DataTransferObjects\ActionDTO $actionDTO
     * 
     * @return array
     */
    public function update($id, ActionDTO $actionDTO)
    {
        $action = app(SaveActionAction::class) ->execute($actionDTO, $id);

        return success_response($action, trans('lang-resources::commons.messages.completed.update'));
    }

    /**
     * Update action field except password by ID
     *
     * @param int|string $id
     * @param string $field
     * @param string|null $value
     *
     * @return array
     */
    public function updateFieldValueById($id, string $field, string $value = null)
    {
        $action = data_helpers($this ->actionRepository ->getModel())
                    ->fromId($id)
                    ->getDataRow([$field]);

        $action ->{$field} = $value;
        $action ->save();

        return success_response($action, trans('lang-resources::commons.messages.completed.update'));
    }

    /**
     * Delete action
     * 
     * @param int|string $id
     * 
     * @return array
     */
    public function delete($id)
    {
        $action = data_helpers($this ->actionRepository ->getModel())
                    ->fromId($id)
                    ->getDataRow(['id'])
                    ->delete();

        return success_response($action, trans('lang-resources::commons.messages.completed.deletion'));
    }

    /**
     * Restore action
     * 
     * @param int|string $id
     * 
     * @return array
     */
    public function restore($id)
    {
        $action = data_helpers($this ->actionRepository ->getModel(), [], true)
                    ->fromId($id)
                    ->getDataRow(['id'])
                    ->restore();

        return success_response($action, trans('lang-resources::commons.messages.completed.restoration'));
    }

    /**
     * Delete action permanently
     * 
     * @param int|string $id
     * 
     * @return array
     */
    public function destroy($id)
    {
        data_helpers($this ->actionRepository ->getModel(), [], true)
            ->fromId($id)
            ->getDataRow(['id'])
            ->forceDelete();

        return success_response(null, trans('lang-resources::commons.messages.completed.permanent_deletion'));
    }
}