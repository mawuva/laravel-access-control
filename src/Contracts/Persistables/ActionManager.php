<?php

namespace Accontrol\Contracts\Persistables;

interface ActionManager
{
    /**
     * Create new action
     *
     * @param array $data
     *
     * @return array
     */
    public function createAction(array $data): array;

    /**
     * Get all actions
     * 
     * @param boolean $paginate
     * 
     * @return array
     */
    public function getActions($paginate = true): array;
    
    /**
     * Retrieve trashed actions
     * 
     * @return array
     */
    public function getDeletedActions(): array;

    /**
     * Search action 
     * 
     * @param string $searchTerm
     * 
     * @return array
     */
    public function searchActions(string $searchTerm, $paginate = false): array;

    /**
     * Get action by ID
     * 
     * @param int|string $action_id
     * @param boolean $deleted
     * 
     * @return array
     */
    public function getAction($action_id, $deleted = false): array;

    /**
     * Get action by slug
     * 
     * @param string $slug
     * 
     * @return array
     */
    public function getActionBySlug(string $slug): array;

    /**
     * Update action data
     * 
     * @param int|string $action_id
     * @param array $data
     * 
     * @return array
     */
    public function updateAction(int|string $action_id, array $data): array;

    /**
     * Delete role
     * 
     * @param int|string $action_id
     * 
     * @return array
     */
    public function deleteAction(int|string $action_id): array;

    /**
     * Restore action account
     * 
     * @param int|string $action_id
     * 
     * @return array
     */
    public function restoreAction(int|string $action_id): array;

    /**
     * Delete action permanently
     * 
     * @param int|string $action_id
     * 
     * @return array
     */
    public function destroyAction(int|string $action_id): array;
}