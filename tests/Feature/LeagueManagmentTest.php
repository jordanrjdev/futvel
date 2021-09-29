<?php

namespace Tests\Feature;

use App\Models\League;
use App\Models\Team;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeagueManagmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function list_of_leagues_can_be_fetched_from_the_api()
    {
        $this->withoutExceptionHandling();

        $leagues = League::factory(2)->create();

        foreach ($leagues as $league) {
            $league->teams()->attach(Team::factory(2)->create()->pluck('id')->toArray());
        }

        $response = $this->get('/api/leagues');

        $response->assertOk();

        $leagues = League::all();

        $response->assertJson([
            'data' => [
                [
                    'data' => [
                        'id' => $leagues->first()->id,
                        'name' => $leagues->first()->name,
                        'description' => $leagues->first()->description,
                        'number_dates' => $leagues->first()->number_dates,
                        'start_date' => $leagues->first()->start_date,
                        'end_date' => $leagues->first()->end_date,
                        'teams' => [
                            'data' => [
                                [

                                    'data' => [
                                        'id' => $leagues->first()->teams->first()->id,
                                    ],
                                ],
                                [

                                    'data' => [
                                        'id' => $leagues->first()->teams->last()->id,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'data' => [
                        'id' => $leagues->last()->id,
                        'name' => $leagues->last()->name,
                        'description' => $leagues->last()->description,
                        'number_dates' => $leagues->last()->number_dates,
                        'start_date' => $leagues->last()->start_date,
                        'end_date' => $leagues->last()->end_date,
                        'teams' => [
                            'data' => [
                                [
                                    'data' => [
                                        'id' => $leagues->last()->teams->first()->id,
                                    ],
                                ],
                                [
                                    'data' => [
                                        'id' => $leagues->last()->teams->last()->id,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

    }

    /** @test */
    public function a_single_league_can_be_fetched_from_the_api()
    {
        $this->withoutExceptionHandling();

        $league = League::factory()->create();

        $league->teams()->attach(Team::factory(2)->create()->pluck('id')->toArray());

        $response = $this->get('/api/league/' . $league->id);

        $response->assertOk();

        $this->assertCount(1, League::all());
        $response->assertJson([
            'data' => [
                'id' => $league->id,
                'name' => $league->name,
                'description' => $league->description,
                'number_dates' => $league->number_dates,
                'start_date' => $league->start_date,
                'end_date' => $league->end_date,
                'teams' => [
                    'data' => [
                        [
                            'data' => [
                                'id' => $league->teams->first()->id,
                            ],
                        ],
                        [
                            'data' => [
                                'id' => $league->teams->last()->id,
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    /** @test */
    public function a_league_can_be_created()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/api/leagues', [
            'name' => 'Test League',
            'description' => 'Test League Description',
            'number_dates' => '10',
            'start_date' => '2020-01-01',
            'end_date' => '2020-12-31',
        ])->assertCreated();

        $this->assertCount(1, League::all());

        $league = League::first();

        $this->assertEquals('Test League', $league->name);
        $this->assertEquals('Test League Description', $league->description);
        $this->assertEquals('10', $league->number_dates);
        $this->assertEquals('2020-01-01', $league->start_date);
        $this->assertEquals('2020-12-31', $league->end_date);

        $response->assertJson([
            'data' => [
                'id' => $league->id,
                'name' => $league->name,
                'description' => $league->description,
                'number_dates' => $league->number_dates,
                'start_date' => $league->start_date,
                'end_date' => $league->end_date,
            ],
        ]);
    }

    /** @test */
    public function a_league_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $league = League::factory()->create();

        $response = $this->put('/api/league/' . $league->id, [
            'name' => 'Test League',
            'description' => 'Test League Description',
            'number_dates' => '10',
            'start_date' => '2020-01-01',
            'end_date' => '2020-12-31',
        ])->assertOk();

        $league = $league->fresh();

        $this->assertCount(1, League::all());

        $this->assertEquals('Test League', $league->name);
        $this->assertEquals('Test League Description', $league->description);
        $this->assertEquals('10', $league->number_dates);
        $this->assertEquals('2020-01-01', $league->start_date);
        $this->assertEquals('2020-12-31', $league->end_date);

        $response->assertJson([
            'data' => [
                'id' => $league->id,
                'name' => $league->name,
                'description' => $league->description,
                'number_dates' => $league->number_dates,
                'start_date' => $league->start_date,
                'end_date' => $league->end_date,
            ],
        ]);
    }

    /** @test */
    public function a_league_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $league = League::factory()->create();

        $response = $this->delete('/api/league/' . $league->id)->assertNoContent();

        $this->assertCount(0, League::all());
    }
}
