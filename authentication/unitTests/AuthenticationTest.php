<?php

class AuthenticationTest extends PHPUnit_Framework_TestCase {

    /**
     * @covers Authentication::userRegistration. Test if data is empty
     */
    public function testuserRegistrationEmpty() {
        $data = array(
            'username' => '',
            'email' => ''
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/authentication/auth/register/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $covertedToString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($covertedToString))
        );
        $result = curl_exec($ch);
        $expectedResult = '"Required fields not filled"';
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @covers Authentication::userRegistration To test if username already exists
     */
    public function testuserRegistrationAlreadyExists() {
        $data = array(
            'username' => 'James',
            'email' => 'james@test.test'
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/authentication/auth/register/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $covertedToString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($covertedToString))
        );
        $result = curl_exec($ch);
        $expectedResult = '"Username Already Exists"';
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @covers Authentication::renew 
     * since the input is empty the token will
     * not be renewed
     */
    public function testRenew() {
        $data = array(
            'token' => '',
            'username' => ''
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/authentication/auth/renew/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $covertedToString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($covertedToString))
        );
        $result = curl_exec($ch);
        $expectedResult = '{"success":0}';
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @covers Authentication::revoke 
     * since the input is empty the token will
     * not be revoked
     */
    public function testRevoked() {
        $data = array(
            'token' => '',
            'username' => ''
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/authentication/auth/revoke/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $covertedToString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($covertedToString))
        );
        $result = curl_exec($ch);
        $expectedResult = '{"success":0}';
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @covers Authentication::validateUser 
     * since the token is valid the user 
     * is authenticated.
     */
    public function testValidateUser() {
        $data = array(
            'token' => 'Enter token here',
            'username' => 'James'
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/authentication/auth/validate/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $covertedToString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($covertedToString))
        );
        $result = curl_exec($ch);
        $expectedResult = '"Authorised"';
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @covers Authentication::validateUser 
     * since the token is invalid the user 
     * is unauthenticated.
     */
    public function testValidateUserBlacklisted() {
        $data = array(
            "token" => 'Enter token here',
            'username' => 'James'
        );
        $covertedToString = json_encode($data);
        $ch = curl_init('http://localhost/authentication/auth/validate/');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $covertedToString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($covertedToString))
        );
        $result = curl_exec($ch);
        $expectedResult = '"Unauthorised"';
        $this->assertEquals($expectedResult, $result);
    }
}
