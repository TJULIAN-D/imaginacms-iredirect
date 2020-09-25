<?php

namespace Modules\Iredirect\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iredirect\Entities\Redirect;
use Modules\Iredirect\Http\Requests\IredirectRequest;
use Modules\Bcrud\Http\Controllers\BcrudController;
use Modules\User\Contracts\Authentication;
use Illuminate\Contracts\Foundation\Application;


class RedirectController extends BcrudController
{
    /**
     * @var RedirectRepository
     */
    private $redirect;
    private $auth;


    public function __construct(Authentication $auth)
    {
        parent::__construct();

        $this->auth = $auth;
        $driver = config('asgard.user.config.driver');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('Modules\Iredirect\Entities\Redirect');
        $this->crud->setRoute('backend/iredirect/redirect');
        $this->crud->setEntityNameStrings(trans('iredirect::redirect.single'), trans('iredirect::redirect.plural'));
        $this->access = [];
        $this->crud->enableAjaxTable();
        $this->crud->orderBy('created_at', 'DESC');
        $this->crud->limit(100);


        /*
        |--------------------------------------------------------------------------
        | COLUMNS AND FIELDS
        |--------------------------------------------------------------------------
        */
        // ------ CRUD COLUMNS
        $this->crud->addColumn([
            'name' => 'id',
            'label' => 'ID',
        ]);

        $this->crud->addColumn([
            'name' => 'from',
            'label' => trans('iredirect::redirect.from'),

        ]);
        $this->crud->addColumn([
            'name' => 'to',
            'label' => trans('iredirect::redirect.to'),

        ]);
        $this->crud->addColumn([
            'name' => 'redirect_type',
            'label' => trans('iredirect::redirect.redirect_type'),
        ]);

        $this->crud->addColumn([
            'name' => 'created_at',
            'label' => trans('iredirect::common.created_at'),
        ]);

        // ------ CRUD FIELDS
        $this->crud->addField([
            'name' => 'from',
            'label' => trans('iredirect::redirect.from'),
            'type' => 'text',
            'viewposition' => 'left',

        ]);

        $this->crud->addField([
            'name' => 'to',
            'label' => trans('iredirect::redirect.to'),
            'type' => 'text',
            'viewposition' => 'left',
        ]);

        $this->crud->addField([
            'name' => 'redirect_type',
            'label' =>trans('iredirect::redirect.redirect_type'),
            'type' => 'select_from_array',
            'options' => [
                301 => trans('iredirect::redirect.301 redirect'),
                302 => trans('iredirect::redirect.302 redirect'),
            ],
            'viewposition' => 'right',
        ]);


        if (config()->has('asgard.iredirect.config.fields')) {
            $fields = config()->get('asgard.iredirect.config.fields');
            foreach ($fields as $field) {
                $this->crud->addField($field);
            }

        }

    }

    public function show($id)
    {

        return abort(404);

    }

    public function setup()
    {
        parent::setup();

        $permissions = ['index', 'create', 'edit', 'destroy'];
        $allowpermissions = ['show'];
        foreach ($permissions as $permission) {

            if ($this->auth->hasAccess("iredirect.redirects.$permission")) {
                if ($permission == 'index') $permission = 'list';
                if ($permission == 'edit') $permission = 'update';
                if ($permission == 'destroy') $permission = 'delete';
                $allowpermissions[] = $permission;
            }

        }
        $this->crud->access = $allowpermissions;
    }

    public function store(IredirectRequest $request)
    {
        return parent::storeCrud($request);
    }

    public function update(IredirectRequest $request)
    {
        return parent::updateCrud($request);
    }

}
