<?php

namespace Mawuekom\Accontrol\Services;

use Illuminate\Http\Response;
use Mawuekom\Accontrol\Actions\SaveRoleAction;
use Mawuekom\Accontrol\DataTransferObjects\RoleDTO;
use Mawuekom\Accontrol\Repositories\RoleRepository;

class RoleService
{
    /**
     * @var \Mawuekom\Accontrol\Repositories\RoleRepository
     */
    protected $roleRepository;

    /**
     * Create new service instance.
     *
     * @param \Mawuekom\Accontrol\Repositories\RoleRepository $roleRepository
     * 
     * @return void
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this ->roleRepository  = $roleRepository;
    }

    /**
     * Return repository instance
     *
     * @return \Mawuekom\Accontrol\Repositories\RoleRepository
     */
    public function fromRepo()
    {
        return $this->roleRepository;
    }

    /**
     * Create new role.
     *
     * @param \Mawuekom\Accontrol\DataTransferObjects\RoleDTO $roleDTO
     *
     * @return array
     */
    public function create(RoleDTO $roleDTO): array
    {
        $role = app(SaveRoleAction::class) ->execute($roleDTO);

        return success_response($role, trans('lang-resources::commons.messages.entity.created', [
            'Entity' => trans_choice('accontrol::entity.role', 1)
        ]), Response::HTTP_CREATED);
    }

    /**
     * Get role by ID
     * 
     * @param int|string $id
     * @param boolean $inTrashed
     * @param array $columns
     * 
     * @return array
     */
    public function getById($id, $inTrashed = false, $columns = ['*'])
    {
        $role = data_helpers($this ->roleRepository ->getModel(), [], $inTrashed)
                    ->fromId($id)
                    ->getDataRow($columns);

        if (is_null($role)) {
            return failure_response(null, trans('lang-resources::commons.messages.resource.not_found'), Response::HTTP_NO_CONTENT);
        }

        else {
            return success_response($role, trans('lang-resources::commons.messages.entity.resource', [
                'Entity' => trans_choice('accontrol::entity.role', 1)
            ]));
        }
    }

    /**
     * Get role by field
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
        $role = data_helpers($this ->roleRepository ->getModel(), [$field, $value], $inTrashed)
                    ->getDataRow($columns);

        if (is_null($role)) {
            return failure_response(null, trans('lang-resources::commons.messages.resource.not_found'), Response::HTTP_NO_CONTENT);
        }

        else {
            return success_response($role, trans('lang-resources::commons.messages.entity.resource', [
                'Entity' => trans_choice('accontrol::entity.role', 1)
            ]));
        }
    }

    /**
     * Update role data
     * 
     * @param int|string $id
     * @param \Mawuekom\Accontrol\DataTransferObjects\RoleDTO $roleDTO
     * 
     * @return array
     */
    public function update($id, RoleDTO $roleDTO)
    {
        $role = app(SaveRoleAction::class) ->execute($roleDTO, $id);

        return success_response($role, trans('lang-resources::commons.messages.completed.update'));
    }

    /**
     * Update role field except password by ID
     *
     * @param int|string $id
     * @param string $field
     * @param string|null $value
     *
     * @return array
     */
    public function updateFieldValueById($id, string $field, string $value = null)
    {
        $role = data_helpers($this ->roleRepository ->getModel())
                    ->fromId($id)
                    ->getDataRow([$field]);

        $role ->{$field} = $value;
        $role ->save();

        return success_response($role, trans('lang-resources::commons.messages.completed.update'));
    }

    /**
     * Delete role
     * 
     * @param int|string $id
     * 
     * @return array
     */
    public function delete($id)
    {
        $role = data_helpers($this ->roleRepository ->getModel())
                    ->fromId($id)
                    ->getDataRow(['id'])
                    ->delete();

        return success_response($role, trans('lang-resources::commons.messages.completed.deletion'));
    }

    /**
     * Restore role
     * 
     * @param int|string $id
     * 
     * @return array
     */
    public function restore($id)
    {
        $role = data_helpers($this ->roleRepository ->getModel(), [], true)
                    ->fromId($id)
                    ->getDataRow(['id'])
                    ->restore();

        return success_response($role, trans('lang-resources::commons.messages.completed.restoration'));
    }

    /**
     * Delete role permanently
     * 
     * @param int|string $id
     * 
     * @return array
     */
    public function destroy($id)
    {
        data_helpers($this ->roleRepository ->getModel(), [], true)
            ->fromId($id)
            ->getDataRow(['id'])
            ->forceDelete();

        return success_response(null, trans('lang-resources::commons.messages.completed.permanent_deletion'));
    }
}
