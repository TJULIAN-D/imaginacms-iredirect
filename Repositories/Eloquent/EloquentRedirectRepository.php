<?php

namespace Modules\Iredirect\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Modules\Iredirect\Entities\Redirect;
use Modules\Iredirect\Entities\Status;
use Modules\Iredirect\Repositories\Collection;
use Modules\Iredirect\Repositories\RedirectRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Laracasts\Presenter\PresentableTrait;

class EloquentRedirectRepository extends EloquentBaseRepository implements RedirectRepository
{
    /**
     * @param  int $id
     * @return object
     */
    public function find($id)
    {
        return $this->model->with('tags')->find($id);
    }


    /**
     * Update a resource
     * @param $redirect
     * @param  array $data
     * @return mixed
     */
    public function update($redirect, $data)
    {
        $redirect->update($data);

        return $redirect;
    }

    /**
     * Create a iredirect redirect
     * @param  array $data
     * @return Redirect
     */
    public function create($data)
    {
        $redirect = $this->model->create($data);

        event(new RedirectWasCreated($redirect, $data));

        return $redirect;
    }

    public function destroy($model)
    {
        return $model->delete();
    }


    /**
     * Find a resource by the given slug
     *
     * @param  string $slug
     * @return object
     */
    public function findBySlug($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }
}
