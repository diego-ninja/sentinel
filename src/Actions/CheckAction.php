<?php

namespace Ninja\Censor\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Ninja\Censor\Checkers\Contracts\ProfanityChecker;
use Ninja\Censor\Http\Resources\CensorResultResource;
use Ninja\Censor\Result\Contracts\Result;

final readonly class CheckAction
{
    use AsAction;

    public function __construct(private ProfanityChecker $checker) {}

    public function handle(string $text): Result
    {
        return $this->checker->check($text);
    }

    public function asController(Request $request): Result
    {
        if (! $request->has('text')) {
            abort(400, 'Missing text parameter');
        }

        /** @var string $text */
        $text = $request->input('text');

        return $this->handle($text);
    }

    public function jsonResponse(Result $result): CensorResultResource
    {
        return new CensorResultResource($result);
    }
}
