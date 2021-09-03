<?php

namespace Mawuekom\Accontrol\Contracts\Persistables;

interface RoleManager
{
    /**
     * Create new role
     *
     * @param array $data
     *
     * @return array
     */
    public function createRole(array $data): array;

    /**
     * Get all roles
     * 
     * @param boolean $paginate
     * 
     * @return array
     */
    public function getRoles($paginate = true): array;
    
    /**
     * Retrieve trashed roles
     * 
     * @return array
     */
    public function getDeletedRoles(): array;

    /**
     * Search role 
     * 
     * @param string $searchTerm
     * 
     * @return array
     */
    public function searchRoles(string $searchTerm, $paginate = false): array;

    /**
     * Get role by ID
     * 
     * @param int|string $role_id
     * @param boolean $deleted
     * 
     * @return array
     */
    public function getRole($role_id, $deleted = false): array;

    /**
     * Get role by slug
     * 
     * @param string $slug
     * 
     * @return array
     */
    public function getRoleBySlug(string $slug): array;

    /**
     * Update role data
     * 
     * @param int|string $role_id
     * @param array $data
     * 
     * @return array
     */
    public function updateRole(int|string $role_id, array $data): array;

    /**
     * Delete role
     * 
     * @param int|string $role_id
     * 
     * @return array
     */
    public function deleteRole(int|string $role_id): array;

    /**
     * Restore role account
     * 
     * @param int|string $role_id
     * 
     * @return array
     */
    public function restoreRole(int|string $role_id): array;

    /**
     * Delete role permanently
     * 
     * @param int|string $role_id
     * 
     * @return array
     */
    public function destroyRole(int|string $role_id): array;
}