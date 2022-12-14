<?php

declare(strict_types=1);

use Alphpaca\MonoplusSplit\Configuration;
use Webmozart\Assert\InvalidArgumentException;

it('throws exception when required environment variable is empty', function (string $environmentToBeRemoved) {
    $environmentVariables = getExampleEnvironmentVariables();
    unset($environmentVariables[$environmentToBeRemoved]);

    expect(fn () => Configuration::createFromEnv($environmentVariables))
        ->toThrow(InvalidArgumentException::class, sprintf('Expected the key "%s" to exist.', $environmentToBeRemoved))
    ;
})->with(array_keys(getExampleEnvironmentVariables()));

it('returns repository URL', function () {
    $configuration = Configuration::createFromEnv(getExampleEnvironmentVariables());

    expect($configuration->repositoryUrl())->toBe('https://git-username:personal-access-token@repository-host/repository-owner/repository-name.git');
});

function getExampleEnvironmentVariables(): array
{
    return [
        'INPUT_PACKAGE_PATH' => 'package',
        'INPUT_PERSONAL_ACCESS_TOKEN' => 'personal-access-token',
        'INPUT_GIT_USERNAME' => 'git-username',
        'INPUT_GIT_EMAIL' => 'git-email',
        'INPUT_REPOSITORY_HOST' => 'repository-host',
        'INPUT_REPOSITORY_OWNER' => 'repository-owner',
        'INPUT_REPOSITORY_NAME' => 'repository-name',
        'INPUT_TARGET_BRANCH' => 'target-branch',
    ];
}
