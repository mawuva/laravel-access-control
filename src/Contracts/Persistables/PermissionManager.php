<?php

namespace Mawuekom\Accontrol\Contracts\Persistables;

interface PermissionManager
{
    /**
     * Create new permission
     *
     * @param array $data
     *
     * @return array
     */
    public function createPermission(array $data): array;

    /**
     * Get all permissions
     * 
     * @param boolean $paginate
     * 
     * @return array
     */
    public function getPermissions($paginate = true): array;
    
    /**
     * Retrieve trashed permissions
     * 
     * @return array
     */
    public function getDeletedPermissions(): array;

    /**
     * Search permission 
     * 
     * @param string $searchTerm
     * 
     * @return array
     */
    public function searchPermissions(string $searchTerm, $paginate = false): array;

    /**
     * Get permission by ID
     * 
     * @param int|string $permission_id
     * @param boolean $deleted
     * 
     * @return array
     */
    public function getPermission($permission_id, $deleted = false): array;

    /**
     * Get permission by slug
     * 
     * @param string $slug
     * 
     * @return array
     */
    public function getPermissionBySlug(string $slug): array;

    /**
     * Update permission data
     * 
     * @param int|string $permission_id
     * @param array $data
     * 
     * @return array
     */
    public function updatePermission(int|string $permission_id, array $data): array;

    /**
     * Delete role
     * 
     * @param int|string $permission_id
     * 
     * @return array
     */
    public function deletePermission(int|string $permission_id): array;

    /**
     * Restore permission account
     * 
     * @param int|string $permission_id
     * 
     * @return array
     */
    public function restorePermission(int|string $permission_id): array;

    /**
     * Delete permission permanently
     * 
     * @param int|string $permission_id
     * 
     * @return array
     */
    public function destroyPermission(int|string $permission_id): array;
}