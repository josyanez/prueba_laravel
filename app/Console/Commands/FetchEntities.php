<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ApiService;
use App\Models\Entity;
use App\Models\Category;

class FetchEntities extends Command
{
    protected $signature = 'fetch:entities';
    protected $description = 'Fetch entities from the public API and store them in the database.';

    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        parent::__construct();
        $this->apiService = $apiService;
    }

    public function handle()
    {
        $entries = $this->apiService->fetchData();

        if (!is_array($entries)) {
            $this->error('No valid data retrieved from the API.');
            return;
        }

        $categories = Category::whereIn('category', ['Animals', 'Security'])->pluck('id', 'category');
        $categoryKeys = $categories->keys()->toArray(); // Convert keys to an array


        foreach ($entries as $entry) {
            if (isset($entry['Category']) && in_array($entry['Category'], $categoryKeys)) {
                Entity::updateOrCreate(
                    ['api' => $entry['API']], 
                    [
                        'description' => $entry['Description'],
                        'link' => $entry['Link'],
                        'category_id' => $categories[$entry['Category']],
                    ]
                );
            }
        }

        $this->info('Entities have been fetched and stored.');
    }
}
