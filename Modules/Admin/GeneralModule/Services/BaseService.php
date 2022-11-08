<?php

namespace Modules\Admin\GeneralModule\Services;

use Modules\Common\Http\Controllers\InitController;
use Modules\Admin\GeneralModule\Repositories\BaseRepositoryInterface;

class BaseService extends InitController
{
    private $baseRepository;

    public function __construct(BaseRepositoryInterface $baseRepository)
    {
        $this->baseRepository = $baseRepository;
    }

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