<?php

namespace Nexus4812\GptCodeFlow\Task;

use Nexus4812\GptCodeFlow\Verification\FailReason;

class CreateClassTask
{
    public string $gptModel;
    public array $firstPrompt;
    public bool $doRetry = true;
    public int $maxRetry = 3;
    public bool $createRequireDevPath = false;
    public array $verifications = [];
    private string $generatedCode = '';
    private FailReason $failReason;

    public function execute(): void
    {
        // プロンプトを送信し、生成されたコードを取得
        $this->generatedCode = $this->callGptModel($this->firstPrompt);
    }

    private function callGptModel(array $prompt): string
    {
        // GPT API 呼び出しの仮想メソッド（実際のAPI呼び出しコードに置き換え）
        // OpenAI APIを呼び出し、生成されたPHPコードを返す
        // ここでは一時的にモックコードを返す例
        return "<?php\n\nclass Example {}";
    }

    public function getGeneratedCode(): string
    {
        return $this->generatedCode;
    }

    public function setFailReason(string $verificationClass, string $errorMessage): void
    {
        $this->failReason = new FailReason($verificationClass, $errorMessage);
    }

    public function getFailReason(): FailReason
    {
        return $this->failReason;
    }

    public function updatePrompt(array $newPrompt): void
    {
        $this->firstPrompt = $newPrompt;
    }

    public function retryPrompt(FailReason $failReason): array
    {
        // リトライ時のプロンプト更新ロジック
        $errorMessage = $failReason->getErrorMessage();
        return [
            [
                'role' => 'user',
                'content' => "The following test generation failed:\n\n$errorMessage\n\n" .
                    "Please try again and fix the issues."
            ],
        ];
    }

    public function getMaxRetry(): int
    {
        return $this->maxRetry;
    }
}
