<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Services\ApiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiServiceTest extends TestCase
{
    use RefreshDatabase;

    public function it_fetches_and_stores_data_correctly()
    {
        Http::fake([
            'api.publicapis.org/entries' => Http::response([
                'count' => 1,
                'entries' => [
                    [
                        'API' => 'AdoptAPet',
                        'Description' => 'Resource to help get pets adopted',
                        'Link' => 'http://web.archive.org/web/20240403172734/https://www.adoptapet.com/public/apis/pet_list.html',
                        'Category' => 'Animals'
                    ]
                ]
            ], 200)
        ]);

        $service = new ApiService();
        $service->fetchAndStore();

        $this->assertDatabaseHas('entities', [
            'api' => 'AdoptAPet',
            'description' => 'Resource to help get pets adopted',
            'link' => 'http://web.archive.org/web/20240403172734/https://www.adoptapet.com/public/apis/pet_list.html'
        ]);

        $this->assertDatabaseHas('categories', [
            'category' => 'Animals'
        ]);
        
    }
}
