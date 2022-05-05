<?php namespace App\Http\Middleware;

use App\Helpers\Http;

class GoogleRecaptcha
{
    public function handle($request, \Closure $next)
    {
        $authorization = $request->header('Authorization');
        if (empty($authorization)) {
            return Http::respuesta(Http::retDenyBot, ['validation' => 'Este punto de acceso es protegido']);
        }

        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret = '--';
        $recaptcha_response = $authorization;

        // Make and decode POST request:
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
        $recaptcha = json_decode($recaptcha);

        // Take action based on the score returned:
        if (property_exists($recaptcha, 'score') && $recaptcha->score < 0.3) {
            return Http::respuesta(Http::retDenyBot, ['validation' => $recaptcha->score]);
        }

        $response = $next($request);
        return $response;
    }
}
