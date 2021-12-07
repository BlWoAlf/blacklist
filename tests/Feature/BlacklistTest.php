<?php

namespace Tests\Feature;

use App\Models\Advertiser;
use App\Models\Publisher;
use App\Models\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Blacklist;

class BlacklistTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test parse from string and save blacklist in DB.
     *
     * @return void
     */
    public function testSaveBlacklist()
    {
        $advertiser = factory(Advertiser::class)->create();
        $sites = factory(Site::class,3)->create();

        $request = [
            'advertiser' => $advertiser->id,
            'blacklist' => 's'.$sites[0]->id.', s'.$sites[1]->id,
        ];

        $response = $this->post(route('save_blacklist'), $request);

        $this->assertDatabaseCount('blacklists', 2);
        $this->assertDatabaseHas('blacklists', [
            'advertiser_id' => $advertiser->id,
            'blacklistable_id' => $sites[1]->id,
            'blacklistable_type' => 'App\Models\Site'
        ]);
    }

    /**
     * test parse from object and get blacklist string.
     *
     * @return void
     */
    public function testGetBlacklist()
    {
        $advertiser = factory(Advertiser::class)->create();
        $sites = factory(Site::class,2)->create();
        $publishers = factory(Publisher::class, 2)->create();

        $advertiser->blacklistSites()->sync($sites->pluck('id'));
        $advertiser->blacklistPublishers()->sync($publishers->pluck('id'));

        $request = [
            'advertiser' => $advertiser->id,
        ];

        $response = $this->get(route('get_blacklist', $request));

        $response->assertViewIs('example');
        $response->assertSee('s'.$sites[0]->id.', s'.$sites[1]->id.', p'.$publishers[0]->id.', p'.$publishers[1]->id);
    }
}
