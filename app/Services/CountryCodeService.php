<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Libraries\QueryExceptionLibrary;
use PragmaRX\Countries\Package\Countries;

class CountryCodeService
{
    /**
     * @throws Exception
     */
    public function list(): array
    {
        try {
            $countryArray = [];
            $countries    = Countries::all();
            foreach ($countries as $key => $country) {
                $countryArray[] = (object)[
                    'country_code' => $key,
                    'country_name' => ($country['admin'] ?? $key) . ' (' . $key . ')',
                ];
            }
            return ['data' => $countryArray];
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception(QueryExceptionLibrary::message($exception), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function show($country)
    {
        try {
            $code = strtoupper(trim((string)$country));
            $found = null;

            if (strlen($code) === 2) {
                $found = Countries::where('cca2', $code)->first();
            }

            if (!$found) {
                $found = Countries::where('cca3', $code)->first();
            }

            if (!$found && strlen($code) !== 2) {
                $found = Countries::where('cca2', $code)->first();
            }

            return $found;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception(QueryExceptionLibrary::message($exception), 422);
        }
    }
}
