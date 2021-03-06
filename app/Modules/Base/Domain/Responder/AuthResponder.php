<?php

namespace App\Modules\Base\Domain\Responder;

use App\Modules\Base\Domain\BaseResponder;
use stdClass;

abstract class AuthResponder extends BaseResponder
{
    protected function forgetAuthCookie($response)
    {
        return $response->withoutCookie(config('app-auth.access_token_name'))
            ->withoutCookie(config('app-auth.refresh_token_name'));
    }
    protected function authNotValid(): void
    {
        $this->response = abort(response()
            ->json([
                'status'    => false,
                'messages'  => $this->payload->getResult()['messages']
            ], 400));
    }
    protected function authenticated(): void
    {
        $this->response =
            $this->forgetAuthCookie(
                response()->json([
                    'status'    => true,
                    'messages' => 'Login Successfully'
                ])
            )->withCookie(
                cookie(
                    config('app-auth.access_token_name'),
                    $this->payload->getResult()['auth']['access_token'],
                    config('app-auth.access_token_exp')
                )
            )
            ->withCookie(
                cookie(
                    config('app-auth.refresh_token_name'),
                    $this->payload->getResult()['auth']['refresh_token'],
                    config('app-auth.refresh_token_exp')
                )
            );
    }
    protected function authLogout(): void
    {
        $this->response = $this->forgetAuthCookie(
            response()->json([
                'status'    => true,
                'messages'  => 'Logout Successfully',
            ])
        );
    }
    protected function authTokenNotFound(): void
    {
        $this->response = abort(
            $this->forgetAuthCookie(
                response()->json([
                    'status'    => false,
                    'messages'  => 'Authorization token not found, please login',
                ], 401)
            )
        );
    }
    protected function authTokenInvalid(): void
    {
        $this->response = abort(
            $this->forgetAuthCookie(
                response()->json([
                    'status'    => false,
                    'messages'  => 'Invalid Token or Expired Token, please login again.',
                ], 403)
            )
        );
    }
    protected function authFailed(): void
    {
        $this->response = abort(
            $this->forgetAuthCookie(
                response()->json([
                    'status'    => false,
                    'messages'  => 'Your login information you entered did not matched our records. Please double check and try again',
                ], 401)
            )
        );
    }
    protected function authVerifyFailed(): void
    {
        $this->response = abort(
            response()->json([
                'status'    => false,
                'messages'  => 'Failed to verify, either expired OTP or already verified',
            ], 400)
        );
    }
    protected function authVerifySuccess(): void
    {
        $this->response = response()->json([
            'status'    => true,
            'messages'  => 'Your Account is verified',
        ], 200);
    }
    protected function authSendEmail(): void
    {
        $this->response = response()->json([
            'status'    => true,
            'messages'  => $this->payload->getResult()['messages']
        ], 200);
    }
    protected function authChangePasswordFailed(): void
    {
        $messages = new stdClass();
        $messages->old_password[] = 'Your old password is incorrect.';
        $this->response = abort(
            response()->json([
                'status' => false,
                'messages' => $messages
            ])
        );
    }
    protected function authChangePasswordSuccess(): void
    {
        $this->response = response()->json([
            'status' => true,
            'messages' => 'Success change your password'
        ], 200);
    }
    protected function authResetPasswordFailed(): void
    {
        $this->response = abort(response()->json([
            'status' => false,
            'messages' => $this->payload->getResult()['messages']
        ], 400));
    }
    protected function authResetPasswordSuccess(): void
    {
        $this->response = response()->json([
            'status' => true,
            'messages' => 'Sucess reset password'
        ], 200);
    }
}
