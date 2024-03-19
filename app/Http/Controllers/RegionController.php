<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\RegionRepositoryInterface;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function __construct(
        protected RegionRepositoryInterface $regionRepository
    ) {}

    public function index(Request $request)
    {
        return $this->regionRepository->getAll();
    }

}
