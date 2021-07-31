<?php

namespace Tests\Feature;

use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ListUserAchievementsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_basic_call_without_data()
    {
        $user = User::factory()->create();
        
        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertStatus(200)
            ->assertJsonStructure(
                [
                  "unlocked_achievements",
                  "next_available_achievements",
                  "current_badge",
                  "next_badge",
                  "remaing_to_unlock_next_badge"
                ]
            );
    }

    public function test_first_lesson_watched()
    {
        # create user
        $user = User::factory()->create();
        
        # create lesson
        $lesson = Lesson::factory()->create();
        
        # add user lesson
        $user->lessons()->sync($lesson->id);

        # fire lesson watched event
        LessonWatched::dispatch($lesson, $user);

        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertStatus(200)
            ->assertExactJson(
                [
                    "unlocked_achievements" => [
                        "First Lesson Watched"
                    ],
                    "next_available_achievements" => [
                        "5 Lessons Watched",
                        "First Comment Written"
                    ],
                    "current_badge" => "Beginner",
                    "next_badge" => "Intermediate",
                    "remaing_to_unlock_next_badge" => 3
                ]
            );
    }

    public function test_two_lessons_watched()
    {
        # create user
        $user = User::factory()->create();
        
        # create lesson
        $lessons = Lesson::factory()->count(2)->create();
        
        # add user lesson
        $user->lessons()->sync($lessons->pluck('id')->toArray());

        foreach ($lessons as $lesson) {
            # fire lesson watched event
            LessonWatched::dispatch($lesson, $user);
        }

        $response = $this->get("/users/{$user->id}/achievements");
        
        # assert exact response as previous test
        $response->assertStatus(200)
            ->assertExactJson(
                [
                    "unlocked_achievements" => [
                        "First Lesson Watched"
                    ],
                    "next_available_achievements" => [
                        "5 Lessons Watched",
                        "First Comment Written"
                    ],
                    "current_badge" => "Beginner",
                    "next_badge" => "Intermediate",
                    "remaing_to_unlock_next_badge" => 3
                ]
            );
    }

    public function test_five_lessons_watched()
    {
        # create user
        $user = User::factory()->create();
        
        # create lesson
        $lessons = Lesson::factory()->count(5)->create();
        
        # add user lesson
        $user->lessons()->sync($lessons->pluck('id')->toArray());

        foreach ($lessons as $lesson) {
            # fire lesson watched event
            LessonWatched::dispatch($lesson, $user);
        }

        $response = $this->get("/users/{$user->id}/achievements");
        
        $response->assertStatus(200)
            ->assertExactJson(
                [
                    "unlocked_achievements" => [
                        "First Lesson Watched",
                        "5 Lessons Watched"
                    ],
                    "next_available_achievements" => [
                        "10 Lessons Watched",
                        "First Comment Written"
                    ],
                    "current_badge" => "Beginner",
                    "next_badge" => "Intermediate",
                    "remaing_to_unlock_next_badge" => 2
                ]
            );
    }

    public function test_first_comment_written()
    {
        # create user
        $user = User::factory()->create();
        
        # create comment
        $comment = Comment::factory()->create();
        
        # update comment with our user
        $user->comments()->save($comment);

        # fire comment written event
        CommentWritten::dispatch($comment);

        $response = $this->get("/users/{$user->id}/achievements");
        
        $response->assertStatus(200)
            ->assertExactJson(
                [
                    "unlocked_achievements" => [
                        "First Comment Written"
                    ],
                    "next_available_achievements" => [
                        "First Lesson Watched",
                        "3 Comments Written"
                    ],
                    "current_badge" => "Beginner",
                    "next_badge" => "Intermediate",
                    "remaing_to_unlock_next_badge" => 3
                ]
            );
    }

    public function test_two_comment_written()
    {
        # create user
        $user = User::factory()->create();
        
        for ($i = 0; $i < 2; $i++) {
            # create comment
            $comment = Comment::factory()->create();
            
            # update comment with our user
            $user->comments()->save($comment);
            
            # fire comment written event
            CommentWritten::dispatch($comment);
        }
        
        $response = $this->get("/users/{$user->id}/achievements");
        
        // assert same as previous response
        $response->assertStatus(200)
            ->assertExactJson(
                [
                    "unlocked_achievements" => [
                        "First Comment Written"
                    ],
                    "next_available_achievements" => [
                        "First Lesson Watched",
                        "3 Comments Written"
                    ],
                    "current_badge" => "Beginner",
                    "next_badge" => "Intermediate",
                    "remaing_to_unlock_next_badge" => 3
                ]
            );
    }

    public function test_three_comment_written()
    {
        # create user
        $user = User::factory()->create();
        
        for ($i = 0; $i < 3; $i++) {
            # create comment
            $comment = Comment::factory()->create();
            
            # update comment with our user
            $user->comments()->save($comment);
            
            # fire comment written event
            CommentWritten::dispatch($comment);
        }
        
        $response = $this->get("/users/{$user->id}/achievements");
        
        $response->assertStatus(200)
            ->assertExactJson(
                [
                    "unlocked_achievements" => [
                        "First Comment Written",
                        "3 Comments Written"
                    ],
                    "next_available_achievements" => [
                        "First Lesson Watched",
                        "5 Comments Written"
                    ],
                    "current_badge" => "Beginner",
                    "next_badge" => "Intermediate",
                    "remaing_to_unlock_next_badge" => 2
                ]
            );
    }

    public function test_three_comment_written_and_five_lesson_watched()
    {
        # create user
        $user = User::factory()->create();
        
        # create lesson
        $lessons = Lesson::factory()->count(5)->create();
        
        # add user lesson
        $user->lessons()->sync($lessons->pluck('id')->toArray());

        foreach ($lessons as $lesson) {
            # fire lesson watched event
            LessonWatched::dispatch($lesson, $user);
        }

        for ($i = 0; $i < 3; $i++) {
            # create comment
            $comment = Comment::factory()->create();
            
            # update comment with our user
            $user->comments()->save($comment);
            
            # fire comment written event
            CommentWritten::dispatch($comment);
        }
        
        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertStatus(200)
            ->assertExactJson(
                [
                    "unlocked_achievements" => [
                        "First Lesson Watched",
                        "5 Lessons Watched",
                        "First Comment Written",
                        "3 Comments Written"
                    ],
                    "next_available_achievements" => [
                        "10 Lessons Watched",
                        "5 Comments Written"
                    ],
                    "current_badge" => "Intermediate",
                    "next_badge" => "Advanced",
                    "remaing_to_unlock_next_badge" => 4
                ]
            );
    }
}
