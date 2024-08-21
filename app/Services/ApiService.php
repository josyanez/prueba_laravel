<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Entity;
use Illuminate\Support\Facades\Http;


class ApiService
{
    public function fetchData()
    {
        $response = Http::get('http://web.archive.org/web/20240403172734/https://api.publicapis.org/entries');

        if ($response->successful()) {
            $data = $response->json();
           // dd($data ); 
            return $data['entries'] ?? []; 
        }
        
        return [];
    }
    public function fetchAndStore()
    {
        //solicitud a la API externa proporcionada
        $response = Http::get('http://web.archive.org/web/20240403172734/https://api.publicapis.org/entries');

        // Verifica si la solicitud fue exitosa
        if ($response->successful()) {
            $entries = $response->json()['entries'];

            foreach ($entries as $entry) {
                $category = Category::firstOrCreate(['category' => $entry['Category']]);

                // Guarda la entidad asociada a la categoría
                Entity::updateOrCreate(
                    ['api' => $entry['API']],
                    [
                        'description' => $entry['Description'],
                        'link' => $entry['Link'],
                        'category_id' => $category->id
                    ]
                );
            }
        }
    }
}
