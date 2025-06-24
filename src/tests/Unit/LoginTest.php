<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Validator;

class LoginTest extends TestCase
{
    private function validate(array $data)
	{
		$request = new LoginRequest();
		return Validator::make($data, $request->rules(), $request->messages());
	}

	/** @test */
	public function it_returns_error_when_email_is_empty()
	{
		$validator = $this->validate([
			'email' => '',
			'password' => 'password123',
		]);

		$this->assertTrue($validator->fails());
		$this->assertEquals('メールアドレスを入力してください', $validator->errors()->first('email'));
	}

    	/** @test */
	public function it_returns_error_when_password_is_empty()
	{
		$validator = $this->validate([
			'email' => 'test@example.com',
			'password' => '',
		]);

		$this->assertTrue($validator->fails());
		$this->assertEquals('パスワードを入力してください', $validator->errors()->first('password'));
	}
}
