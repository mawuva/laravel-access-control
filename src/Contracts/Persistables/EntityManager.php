<?php

namespace Mawuekom\Accontrol\Contracts\Persistables;

interface EntityManager
{
    /**
     * Create new entity
     *
     * @param array $data
     *
     * @return array
     */
    public function createEntity(array $data): array;

    /**
     * Get all entities
     * 
     * @param boolean $paginate
     * 
     * @return array
     */
    public function getEntities($paginate = true): array;
    
    /**
     * Retrieve trashed entities
     * 
     * @return array
     */
    public function getDeletedEntities(): array;

    /**
     * Search entity 
     * 
     * @param string $searchTerm
     * 
     * @return array
     */
    public function searchEntities(string $searchTerm, $paginate = false): array;

    /**
     * Get entity by ID
     * 
     * @param int|string $entity_id
     * @param boolean $deleted
     * 
     * @return array
     */
    public function getEntity($entity_id, $deleted = false): array;

    /**
     * Get entity by slug
     * 
     * @param string $slug
     * 
     * @return array
     */
    public function getEntityBySlug(string $slug): array;

    /**
     * Update entity data
     * 
     * @param int|string $entity_id
     * @param array $data
     * 
     * @return array
     */
    public function updateEntity(int|string $entity_id, array $data): array;

    /**
     * Delete role
     * 
     * @param int|string $entity_id
     * 
     * @return array
     */
    public function deleteEntity(int|string $entity_id): array;

    /**
     * Restore entity account
     * 
     * @param int|string $entity_id
     * 
     * @return array
     */
    public function restoreEntity(int|string $entity_id): array;

    /**
     * Delete entity permanently
     * 
     * @param int|string $entity_id
     * 
     * @return array
     */
    public function destroyEntity(int|string $entity_id): array;
}