<?php

namespace App\Providers;

use SocialiteProviders\Manager\ServiceProvider as SocialiteServiceProvider;

class CustomLinkedInProvider extends SocialiteServiceProvider
{
    protected function getAuthUrl($state)
    {
        $url = $this->buildAuthUrlFromBase($this->baseUrl . '/oauth/v2/authorization');
        return $url . '?' . http_build_query([
            'response_type' => 'code',
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUrl,
            'state' => $state,
            'scope' => $this->formatScopes($this->scopes, $this->scopeSeparator),
            'prompt' => $this->prompt,
            'grant_type' => 'authorization_code',
            // 예상되는 변경 내용
            'https' => true // or any other header
        ]);
    }
}
