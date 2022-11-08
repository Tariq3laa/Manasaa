<?php

namespace Modules\Admin\GeneralModule\Repositories;

use Modules\Common\Helpers\Traits\ApiPaginator;

class BaseRepository implements BaseRepositoryInterface
{
    use ApiPaginator;

    public function index() 
    {}

    public function store($request)
    {}

    public function show($request)
    {}

    public function update($request)
    {}

    public function destroy($request)
    {}
}