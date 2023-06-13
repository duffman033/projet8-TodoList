<?php

namespace App\Tests\Security;

use App\Entity\Task;
use App\Entity\User;
use App\Security\TaskVoter;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskVoterTest extends TestCase
{
    private TaskVoter $taskVoter;

    public function setUp(): void
    {
        $this->taskVoter = new TaskVoter();
    }

    /**
     * @dataProvider voteOnAttributeDataprovider
     */
    public function testVoteOnAttribute(bool $expected, string $attribute, object $subject, ?UserInterface $user): void
    {
        $token = $this->createMock(TokenInterface::class);
        $token->method('getUser')->willReturn($user);

        $this->assertEquals($expected, $this->taskVoter->voteOnAttribute($attribute, $subject, $token));
    }

    public function voteOnAttributeDataprovider(): \Generator
    {
        $user = $this->createMock(User::class);
        $user->method('getId')->willReturn(1);

        $otherUser = $this->createMock(User::class);
        $otherUser->method('getId')->willReturn(2);

        $task = $this->createMock(Task::class);
        $task->method('getUser')->willReturn($user);


        yield 'DELETE User' => [true, TaskVoter::DELETE, $task, $user];
        yield 'EDIT User' => [true, TaskVoter::EDIT, $task, $user];
        yield 'MOVE User' => [false, 'move', $task, $user];
        yield 'EDIT other User' => [false, TaskVoter::EDIT, $task, $otherUser];

        yield 'DELETE non User' => [false, TaskVoter::DELETE, $task, null];
        yield 'EDIT non User' => [false, TaskVoter::EDIT, $task, null];
        yield 'MOVE non User' => [false, 'move', $task, null];
    }
}
