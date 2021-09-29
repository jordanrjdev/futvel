<?php

namespace Tests\Feature;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerManagmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function list_of_players_can_be_fetched_from_the_api()
    {
        $this->withoutExceptionHandling();

        $players = Player::factory(2)->create();

        $response = $this->get('/api/players');

        $response->assertOk();

        $response->assertJson([
            'data' => [
                [
                    'data' => [
                        'id' => $players->first()->id,
                        'name' => $players->first()->name,
                        'position' => $players->first()->position,
                        'team' => [
                            'data' => [
                                'id' => $players->first()->team->id,
                            ],
                        ],
                    ],
                ],
                [
                    'data' => [
                        'id' => $players->last()->id,
                        'name' => $players->last()->name,
                        'position' => $players->last()->position,
                        'team' => [
                            'data' => [
                                'id' => $players->last()->team->id,
                            ],
                        ],
                    ],
                ],
            ],
        ]);

    }

    /** @test */
    public function a_single_player_can_be_fetched_from_the_api()
    {
        $this->withoutExceptionHandling();

        $player = Player::factory()->create();

        $response = $this->get('/api/player/' . $player->id);

        $response->assertOk();

        $this->assertCount(1, Player::all());
        $response->assertJson([
            'data' => [
                'name' => $player->name,
                'position' => $player->position,
                'team' => [
                    'data' => [
                        'id' => $player->team->id,
                    ],
                ],
            ],
        ]);
    }

    /** @test */
    public function a_player_can_be_created()
    {
        $this->withoutExceptionHandling();

        $team = Team::factory()->create();

        $response = $this->post('/api/players', [
            'name' => 'Test Player',
            'position' => 'Defender',
            'team_id' => $team->id,
        ])->assertCreated();

        $this->assertCount(1, Player::all());

        $player = Player::first();

        $this->assertEquals('Test Player', $player->name);
        $this->assertEquals('Defender', $player->position);
        $this->assertEquals($team->id, $player->team->id);

        $response->assertJson([
            'data' => [
                'id' => $player->id,
                'name' => $player->name,
                'position' => $player->position,
                'team' => [
                    'data' => [
                        'id' => $player->team->id,
                    ],
                ],
            ],
        ]);
    }

    /** @test */
    public function a_player_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $player = Player::factory()->create();

        $response = $this->put('/api/player/' . $player->id, [
            'name' => 'Test Player',
            'position' => 'Defender',
        ])->assertOk();

        $player = $player->fresh();

        $this->assertCount(1, Player::all());

        $this->assertEquals('Test Player', $player->name);
        $this->assertEquals('Defender', $player->position);

        $response->assertJson([
            'data' => [
                'id' => $player->id,
                'name' => $player->name,
                'position' => $player->position,
                'team' => [
                    'data' => [
                        'id' => $player->team->id,
                    ],
                ],
            ],
        ]);
    }

    /** @test */
    public function a_player_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $player = Player::factory()->create();

        $response = $this->delete('/api/player/' . $player->id)->assertNoContent();

        $this->assertCount(0, Player::all());
    }
}
