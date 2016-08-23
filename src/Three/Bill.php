<?php

namespace Billplz\Three;

use InvalidArgumentException;

class Bill extends Request
{
    /**
     * Create a new bill.
     *
     * @param  string  $collectionId
     * @param  array  $params
     *
     * @throws  \InvalidArgumentException
     *
     * @return \Laravie\Codex\Response
     */
    public function create(
        $collectionId,
        array $params = []
    ) {
        if (empty($params['email']) && empty($params['mobile'])) {
            throw new InvalidArgumentException('Either $email or $mobile should be present');
        }

        $body = $params;

        $body['collection_id'] = $collectionId;
        // $body['callback_url'] = $callbackUrl;

        return $this->send('POST', 'bills', [], $body);
    }

    /**
     * Show an existing bill.
     *
     * @param  string  $id
     *
     * @return \Laravie\Codex\Response
     */
    public function show($id)
    {
        return $this->send('GET', "bills/{$id}");
    }

    /**
     * Destroy an existing bill.
     *
     * @param  string  $id
     *
     * @return \Laravie\Codex\Response
     */
    public function destroy($id)
    {
        return $this->send('DELETE', "bills/{$id}");
    }

    /**
     * Parse webhook data for a bill.
     *
     * @param  array  $data
     *
     * @return array
     */
    public function webhook(array $data = [])
    {
        if (! $this->hasSanitizer()) {
            return $data;
        }

        return $this->getSanitizer()->to($data);
    }
}
