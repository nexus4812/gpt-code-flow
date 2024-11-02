<?php
namespace Nexus4812\GptCodeFlow\Flow;

use Nexus4812\GptCodeFlow\Task\CreateClassTask;
use Symfony\Component\Finder\Finder;
class FlowManager
{
    private array $tasks = [];
    private int $maxRetry = 3;

    // タスクの追加
    public function addTask(Finder $finder, CreateClassTask $task): void
    {
        $this->tasks[] = $task;
    }

    // 全タスクを実行
    public function run(): void
    {
        foreach ($this->tasks as $task) {
            $this->executeTaskWithRetry($task);
        }
    }

    // 各タスクのリトライ処理
    private function executeTaskWithRetry(CreateClassTask $task): void
    {
        $retryCount = 0;

        do {
            // タスクの実行
            $task->execute();

            // 検証処理を実行
            $isVerified = $this->verifyTask($task);

            if ($isVerified) {
                echo "タスクが成功しました。\n";
                break;
            }

            // リトライカウントの増加
            $retryCount++;
            echo "タスクが失敗しました。リトライ試行回数: $retryCount\n";

            // リトライが必要か確認
            if ($task->doRetry && $retryCount < $this->maxRetry) {
                $retryPrompt = $task->retryPrompt($task->getFailReason());
                $task->updatePrompt($retryPrompt);
            } else {
                echo "リトライ回数が上限に達しました。\n";
                break;
            }
        } while ($retryCount < $this->maxRetry);
    }

    // タスクの検証処理
    private function verifyTask(CreateClassTask $task): bool
    {
        foreach ($task->verifications as $verificationClass) {
            $verification = new $verificationClass();
            $result = $verification->check($task->getGeneratedCode());

            if (!$result->isSuccessful()) {
                $task->setFailReason($verificationClass, $result->getErrorMessage());
                return false;
            }
        }
        return true;
    }
}
