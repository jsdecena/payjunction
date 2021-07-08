<?php

namespace Jsdecena\Payjunction\Services;

use Jsdecena\Payjunction\Validators\Validator;

abstract class BaseService
{
    protected $username;
    protected $password;
    protected $appKey;

    /**
     * Default headers
     */
    protected function getHeaders(): array
    {
        return [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode($this->username . ':' . $this->password),
                'X-PJ-Application-Key' => $this->appKey
            ]
        ];
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $appKey
     *
     * @return void
     */
    protected function setConfigurations(string $username, string $password, string $appKey): void
    {
        $this->username = $username;
        $this->password = $password;
        $this->appKey = $appKey;
    }

    /**
     * @param bool false $isProduction
     *
     * @return string
     */
    protected function getHost(bool $isProduction = false): string
    {
        if ($isProduction) {
            return 'https://api.payjunction.com';
        }
        return 'https://api.payjunctionlabs.com';
    }

    /**
     * @param array $fields
     * @param array $rules
     *
     * @return array
     */
    public function validate(array $fields, array $rules): array
    {
        $messages = [
            'required' => 'The :attribute field is required.',
            'firstName' => 'The :attribute field is required.',
            'lastName' => 'The :attribute field is required.',
        ];

        $validator = Validator::make()->make($fields, $rules, $messages);

        $errorMessages = [];
        if($validator->fails()){
            $errors = $validator->errors();
            foreach($errors->all() as $message){
                $errorMessages[] = $message;
            }
        }

        return $errorMessages;
    }
}
