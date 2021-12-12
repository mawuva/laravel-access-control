<?php

namespace Mawuekom\Accontrol\Services;

use Illuminate\Http\Response;
use Mawuekom\Accontrol\Actions\SaveEntityAction;
use Mawuekom\Accontrol\DataTransferObjects\EntityDTO;
use Mawuekom\Accontrol\Repositories\EntityRepository;

class EntityService
{
    /**
     * @var \Mawuekom\Accontrol\Repositories\EntityRepository
     */
    protected $entityRepository;

    /**
     * Create new service instance.
     *
     * @param \Mawuekom\Accontrol\Repositories\EntityRepository $entityRepository
     * 
     * @return void
     */
    public function __construct(EntityRepository $entityRepository)
    {
        $this ->entityRepository  = $entityRepository;
    }

    /**
     * Return repository instance
     *
     * @return \Mawuekom\Accontrol\Repositories\EntityRepository
     */
    public function fromRepo()
    {
        return $this->entityRepository;
    }

    /**
     * Create new entity.
     *
     * @param \Mawuekom\Accontrol\DataTransferObjects\EntityDTO $entityDTO
     *
     * @return array
     */
    public function create(EntityDTO $entityDTO): array
    {
        $entity = app(SaveEntityAction::class) ->execute($entityDTO);

        return success_response($entity, trans('lang-resources::commons.messages.entity.created', [
            'Entity' => trans_choice('accontrol::entity.entity', 1)
        ]), Response::HTTP_CREATED);
    }

    /**
     * Get entity by ID
     * 
     * @param int|string $id
     * @param boolean $inTrashed
     * @param array $columns
     * 
     * @return array
     */
    public function getById($id, $inTrashed = false, $columns = ['*'])
    {
        $entity = data_helpers($this ->entityRepository ->getModel(), [], $inTrashed)
                    ->fromId($id)
                    ->getDataRow($columns);

        if (is_null($entity)) {
            return failure_response(null, trans('lang-resources::commons.messages.resource.not_found'), Response::HTTP_NO_CONTENT);
        }

        else {
            return success_response($entity, trans('lang-resources::commons.messages.entity.resource', [
                'Entity' => trans_choice('accontrol::entity.entity', 1)
            ]));
        }
    }

    /**
     * Get entity by field
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
        $entity = data_helpers($this ->entityRepository ->getModel(), [$field, $value], $inTrashed)
                    ->getDataRow($columns);

        if (is_null($entity)) {
            return failure_response(null, trans('lang-resources::commons.messages.resource.not_found'), Response::HTTP_NO_CONTENT);
        }

        else {
            return success_response($entity, trans('lang-resources::commons.messages.entity.resource', [
                'Entity' => trans_choice('accontrol::entity.entity', 1)
            ]));
        }
    }

    /**
     * Update entity data
     * 
     * @param int|string $id
     * @param \Mawuekom\Accontrol\DataTransferObjects\EntityDTO $entityDTO
     * 
     * @return array
     */
    public function update($id, EntityDTO $entityDTO)
    {
        $entity = app(SaveEntityAction::class) ->execute($entityDTO, $id);

        return success_response($entity, trans('lang-resources::commons.messages.completed.update'));
    }

    /**
     * Update entity field except password by ID
     *
     * @param int|string $id
     * @param string $field
     * @param string|null $value
     *
     * @return array
     */
    public function updateFieldValueById($id, string $field, string $value = null)
    {
        $entity = data_helpers($this ->entityRepository ->getModel())
                    ->fromId($id)
                    ->getDataRow([$field]);

        $entity ->{$field} = $value;
        $entity ->save();

        return success_response($entity, trans('lang-resources::commons.messages.completed.update'));
    }

    /**
     * Delete entity
     * 
     * @param int|string $id
     * 
     * @return array
     */
    public function delete($id)
    {
        $entity = data_helpers($this ->entityRepository ->getModel())
                    ->fromId($id)
                    ->getDataRow(['id'])
                    ->delete();

        return success_response($entity, trans('lang-resources::commons.messages.completed.deletion'));
    }

    /**
     * Restore entity
     * 
     * @param int|string $id
     * 
     * @return array
     */
    public function restore($id)
    {
        $entity = data_helpers($this ->entityRepository ->getModel(), [], true)
                    ->fromId($id)
                    ->getDataRow(['id'])
                    ->restore();

        return success_response($entity, trans('lang-resources::commons.messages.completed.restoration'));
    }

    /**
     * Delete entity permanently
     * 
     * @param int|string $id
     * 
     * @return array
     */
    public function destroy($id)
    {
        data_helpers($this ->entityRepository ->getModel(), [], true)
            ->fromId($id)
            ->getDataRow(['id'])
            ->forceDelete();

        return success_response(null, trans('lang-resources::commons.messages.completed.permanent_deletion'));
    }
}