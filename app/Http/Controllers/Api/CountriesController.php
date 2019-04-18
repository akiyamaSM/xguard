<?php

namespace xguard\Http\Controllers\Api;

use xguard\Repositories\Country\CountryRepository;
use xguard\Transformers\CountryTransformer;

/**
 * Class CountriesController
 * @package xguard\Http\Controllers\Api
 */
class CountriesController extends ApiController
{
    /**
     * @var CountryRepository
     */
    private $countries;

    public function __construct(CountryRepository $countries)
    {
        $this->middleware('auth');
        $this->countries = $countries;
    }

    /**
     * Get list of all available countries.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->respondWithCollection(
            $this->countries->all(),
            new CountryTransformer
        );
    }
}
