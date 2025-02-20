<?php

namespace Ninja\Sentinel\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Ninja\Sentinel\Checkers\Contracts\ProfanityChecker;
use Ninja\Sentinel\Http\Resources\ResultResource;
use Ninja\Sentinel\Result\Contracts\Result;

final readonly class CheckAction
{
    use AsAction;

    public function __construct(private ProfanityChecker $checker) {}

    public function handle(string $text): Result
    {
        return $this->checker->check($text);
    }

    public function asController(Request $request): ResultResource
    {
        if ( ! $request->has('text')) {
            abort(400, 'Missing text parameter');
        }

        /** @var string $text */
        $text = $request->input('text');

        $result = $this->handle($text);
        return new ResultResource($result);
    }
}
