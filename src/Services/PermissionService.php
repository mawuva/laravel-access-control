<?php

namespace Mawuekom\Accontrol\Services;

use Illuminate\Http\Response;
use Mawuekom\Accontrol\Actions\SavePermissionAction;
use Mawuekom\Accontrol\DataTransferObjects\PermissionDTO;
use Mawuekom\Accontrol\Repositories\PermissionRepository;

class PermissionService
{
    /**
     * @var \Mawuekom\Accontrol\Repositories\PermissionRepository
     */
    protected $permissionRepository;

    /**
     * Create new service instance.
     *
     * @param \Mawuekom\Accontrol\Repositories\PermissionRepository $permissionRepository
     * 
     * @return void
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this ->permissionRepository  = $permissionRepository;
    }

    /**
     * Return repository instance
     *
     * @return \Mawuekom\Accontrol\Repositories\PermissionRepository
     */
    public function fromRepo()
    {
        return $this->permissionRepository;
    }

    /**
     * Create new permission.
     *
     * @param \Mawuekom\Accontrol\DataTransferObjects\PermissionDTO $permissionDTO
     *
     * @return array
     */
    public function create(PermissionDTO $permissionDTO): array
    {
        $permission = app(SavePermissionAction::class) ->execute($permissionDTO);

        return success_response($permission, trans('lang-resources::commons.messages.entity.created', [
            'Entity' => trans_choice('accontrol::entity.permission', 1)
        ]), Response::HTTP_CREATED);
    }

    /**
     * Get permission by ID
     * 
     * @param int|string $id
     * @param boolean $inTrashed
     * @param array $columns
     * 
     * @return array
     */
    public function getById($id, $inTrashed = false, $columns = ['*'])
    {
        $permission = data_helpers($this ->permissionRepository ->getModel(), [], $inTrashed)
                    ->fromId($id)
                    ->getDataRow($columns);

        if (is_null($permission)) {
            return failure_response(null, trans('lang-resources::commons.messages.resource.not_found'), Response::HTTP_NO_CONTENT);
        }

        else {
            return success_response($permission, trans('lang-resources::commons.messages.entity.resource', [
                'Entity' => trans_choice('accontrol::entity.permission', 1)
            ]));
        }
    }

    /**
     * Get permission by field
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
        $permission = data_helpers($this ->permissionRepository ->getModel(), [$field, $value], $inTrashed)
                    ->getDataRow($columns);

        if (is_null($permission)) {
            return failure_response(null, trans('lang-resources::commons.messages.resource.not_found'), Response::HTTP_NO_CONTENT);
        }

        else {
            return success_response($permission, trans('lang-resources::commons.messages.entity.resource', [
                'Entity' => trans_choice('accontrol::entity.permission', 1)
            ]));
        }
    }

    /**
     * Update permission data
     * 
     * @param int|string $id
     * @param \Mawuekom\Accontrol\DataTransferObjects\PermissionDTO $permissionDTO
     * 
     * @return array
     */
    public function update($id, PermissionDTO $permissionDTO)
    {
        $permission = app(SavePermissionAction::class) ->execute($permissionDTO, $id);

        return success_response($permission, trans('lang-resources::commons.messages.completed.update'));
    }

    /**
     * Update permission field except password by ID
     *
     * @param int|string $id
     * @param string $field
     * @param string|null $value
     *
     * @return array
     */
    public function updateFieldValueById($id, string $field, string $value = null)
    {
        $permission = data_helpers($this ->permissionRepository ->getModel())
                    ->fromId($id)
                    ->getDataRow([$field]);

        $permission ->{$field} = $value;
        $permission ->save();

        return success_response($permission, trans('lang-resources::commons.messages.completed.update'));
    }

    /**
     * Delete permission
     * 
     * @param int|string $id
     * 
     * @return array
     */
    public function delete($id)
    {
        $permission = data_helpers($this ->permissionRepository ->getModel())
                    ->fromId($id)
                    ->getDataRow(['id'])
                    ->delete();

        return success_response($permission, trans('lang-resources::commons.messages.completed.deletion'));
    }

    /**
     * Restore permission
     * 
     * @param int|string $id
     * 
     * @return array
     */
    public function restore($id)
    {
        $permission = data_helpers($this ->permissionRepository ->getModel(), [], true)
                    ->fromId($id)
                    ->getDataRow(['id'])
                    ->restore();

        return success_response($permission, trans('lang-resources::commons.messages.completed.restoration'));
    }

    /**
     * Delete permission permanently
     * 
     * @param int|string $id
     * 
     * @return array
     */
    public function destroy($id)
    {
        data_helpers($this ->permissionRepository ->getModel(), [], true)
            ->fromId($id)
            ->getDataRow(['id'])
            ->forceDelete();

        return success_response(null, trans('lang-resources::commons.messages.completed.permanent_deletion'));
    }
}