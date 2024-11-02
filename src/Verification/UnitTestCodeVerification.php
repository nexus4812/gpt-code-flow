<?php

namespace Nexus4812\GptCodeFlow\Verification;

class UnitTestCodeVerification implements VerificationInterface
{
    public function verification(string $pathToGenerated): string|bool
    {
        // PHPUnitコマンドでテストを実行
        $output = shell_exec("vendor/bin/phpunit $pathToGenerated 2>&1");

        // 実行結果を確認して、エラーがあればfalse、正常であればtrueを返す
        if (
            str_contains($output, 'error') ||
            str_contains($output, 'failure') ||
            str_contains($output, 'Failed')
        ) {
            return $output;
        }
        return true;
    }
}
