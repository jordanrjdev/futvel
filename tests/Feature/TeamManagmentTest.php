<?php

namespace Tests\Feature;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamManagmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function list_of_teams_can_be_fetched_from_the_api()
    {
        $this->withoutExceptionHandling();

        Team::factory(2)->create();

        $response = $this->get('/api/teams');

        $response->assertOk();

        $teams = Team::all();

        $response->assertJson([
            'data' => [
                [
                    'data' => [
                        'id' => $teams->first()->id,
                        'name' => $teams->first()->name,
                    ],
                ],
                [
                    'data' => [
                        'id' => $teams->last()->id,
                        'name' => $teams->last()->name,
                    ],
                ],
            ],
        ]);

    }

    /** @test */
    public function a_single_team_can_be_fetched_from_the_api()
    {
        $this->withoutExceptionHandling();

        $team = Team::factory()->create();

        $response = $this->get('/api/team/' . $team->id);

        $response->assertOk();

        $this->assertCount(1, Team::all());

        $response->assertJson([
            'data' => [
                'id' => $team->id,
                'name' => $team->name,
            ],
        ]);
    }

    /** @test */
    public function a_team_can_be_created()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/api/teams', [
            'name' => 'Test Team',
        ])->assertCreated();

        $this->assertCount(1, Team::all());

        $team = Team::first();

        $this->assertEquals('Test Team', $team->name);

        $response->assertJson([
            'data' => [
                'id' => $team->id,
                'name' => $team->name,
            ],
        ]);
    }

    /** @test */
    public function a_team_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $team = Team::factory()->create();

        $response = $this->put('/api/team/' . $team->id, [
            'name' => 'Test Team',
        ])->assertOk();

        $team = $team->fresh();

        $this->assertCount(1, Team::all());

        $this->assertEquals('Test Team', $team->name);

        $response->assertJson([
            'data' => [
                'id' => $team->id,
                'name' => $team->name,
            ],
        ]);
    }

    /** @test */
    public function a_team_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $team = Team::factory()->create();

        $response = $this->delete('/api/team/' . $team->id)->assertNoContent();

        $this->assertCount(0, Team::all());
    }

    /** @test */
    public function list_of_players_of_a_team_can_be_fetched_from_the_api()
    {
        $this->withoutExceptionHandling();

        $team = Team::factory()->create();

        $team->players()->saveMany(Player::factory(2)->create());

        $response = $this->get('/api/team/' . $team->id . '/players');

        $response->assertOk();

        $this->assertCount(2, Player::all());

        $response->assertJson([
            'data' => [
                'name' => $team->name,
                'players' => [
                    'data' => [
                        [
                            'data' => [
                                'id' => $team->players->first()->id,
                            ],
                        ],
                        [
                            'data' => [
                                'id' => $team->players->last()->id,
                            ],
                        ],
                    ],
                ],
            ],
        ]);

    }
}
