<?php

namespace Nexus4812\GptCodeFlow\Task;

class GenerateInfo
{
    public GenerateMode $mode;

    /**
     * 生成元となるクラスのpath
     *
     * @var string|null
     */
    public string|null $pathToBaseClass;

    /**
     * 生成先のクラスpath
     *
     * @var string|null
     */
    public string|null $pathToGenerate;
}
