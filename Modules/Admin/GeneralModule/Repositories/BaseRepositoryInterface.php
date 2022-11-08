<?php

namespace Modules\Admin\GeneralModule\Repositories;

interface BaseRepositoryInterface 
{
    public function index();
    public function store($request);
    public function show($request);
    public function update($request);
    public function destroy($request);
}