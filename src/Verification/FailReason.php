<?php

namespace Nexus4812\GptCodeFlow\Verification;

class FailReason
{
    private array $failMessages = [];

    /**
     * コンストラクタ
     *
     * @param string $verificationClass
     * @param string $errorMessage
     */
    public function __construct(string $verificationClass = '', string $errorMessage = '')
    {
        if ($verificationClass && $errorMessage) {
            $this->addFailMessage($verificationClass, $errorMessage);
        }
    }

    /**
     * 失敗メッセージを追加
     *
     * @param string $verificationClass
     * @param string $errorMessage
     */
    public function addFailMessage(string $verificationClass, string $errorMessage): void
    {
        if (!class_exists($verificationClass)) {
            throw new \LogicException();
        }

        $this->failMessages[$verificationClass] = $errorMessage;
    }

    /**
     * 指定されたクラスに対する失敗メッセージを取得
     *
     * @param string $verificationClass
     * @return string|null
     */
    public function getFailMessage(string $verificationClass): ?string
    {
        return $this->failMessages[$verificationClass] ?? null;
    }

    /**
     * すべての失敗メッセージを取得
     *
     * @return array
     */
    public function getAllFailMessages(): array
    {
        return $this->failMessages;
    }

    /**
     * 失敗メッセージが存在するか確認
     *
     * @return bool
     */
    public function hasFailures(): bool
    {
        return !empty($this->failMessages);
    }
}

