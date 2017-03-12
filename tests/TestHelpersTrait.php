<?php

trait TestHelpersTrait
{
    private $token;

    public function assertLogin($email, $password)
    {
        // Assert that the login has succeeded.
        $this->post('/api/auth/login', [
            'email' => $email,
            'password' => $password
        ])->seeJson([
            "message" => "token_generated"
        ]);
        
        // If it has, pull out the JSON response and save the token.
        $response = json_decode($this->response->getContent());
        $this->token = $response->data->token;

        $this->refreshApplication();
    }

    protected function actingAsApiUser($user)
    {        
        $this->actingAs($user);
        $this->app['api.auth']->setUser($user);

        return $this;
    }

}