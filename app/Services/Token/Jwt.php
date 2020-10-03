<?php

namespace App\Services\Token;

use Exception;
use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS512;
use MiladRahimi\Jwt\Cryptography\Signer;
use MiladRahimi\Jwt\Cryptography\Verifier;
use MiladRahimi\Jwt\Generator;
use MiladRahimi\Jwt\Parser;

class Jwt implements Token
{
    /**
     * @var Signer
     */
    private $signer;

    /**
     * @var Verifier
     */
    private $verifier;

    /**
     * Jwt constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->signer = $this->verifier = new HS512(config('token.types.jwt.key'));
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function generate(int $userId): string
    {
        return (new Generator($this->signer))->generate([
            'sub' => $userId,
            'exp' => time() + config('token.types.jwt.ttl'),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function extract(string $jwt): ?int
    {
        try {
            return (new Parser($this->verifier))->parse($jwt)['sub'];
        } catch (Exception $e) {
            return null;
        }
    }
}
