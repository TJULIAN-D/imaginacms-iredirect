<?php

namespace Modules\Iredirect\Repositories\Cache;

use Modules\Iredirect\Repositories\Collection;
use Modules\Iredirect\Repositories\RedirectRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheRedirectDecorator extends BaseCacheDecorator implements RedirectRepository
{
    public function __construct(RedirectRepository $redirect)
    {
        parent::__construct();
        $this->entityName = 'redirects';
        $this->repository = $redirect;
    }

    /**
     * Get the previous redirect of the given redirect
     * @param object $redirect
     * @return object
     */
    public function findBySlug($slug)
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.findBySlug.{$slug}", $this->cacheTime,
                function () use ($slug) {
                    return $this->repository->findBySlug($slug);
                }
            );
    }

    /**
     * Get the next redirect of the given redirect
     * @param object $id
     * @return object
     */
    public function find($id)
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.find.{$id}", $this->cacheTime,
                function () use ($id) {
                    return $this->repository->getNextOf($id);
                }
            );
    }
}
